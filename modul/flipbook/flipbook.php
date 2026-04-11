<?php
/**
 * Flipbook Frontend Module
 * Menampilkan daftar buku dari database dan viewer flipbook berbasis PDF.js
 */

global $koneksi_db;

$action = isset($_GET['act']) ? cleartext($_GET['act']) : '';
$book_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
?>

<style>
/* ===================== FLIPBOOK SECTION STYLES ===================== */
.flipbook-page {
    background: #f4f6f9;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* --- Section Header --- */
.flipbook-section-header {
    text-align: center;
    padding: 50px 0 30px;
}
.flipbook-section-header .label-top {
    color: #42a5f5;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 600;
}
.flipbook-section-header h2 {
    color: #0d47a1;
    font-size: 32px;
    font-weight: 800;
    margin: 8px 0 0;
}

/* --- Bookshelf --- */
.bookshelf-wrapper {
    background: linear-gradient(to bottom, #f4f6f9 0%, #e8ecf1 100%);
    padding: 20px 0 50px;
}
.bookshelf-row {
    position: relative;
    padding: 20px 20px 30px;
    margin-bottom: 30px;
    background: linear-gradient(to bottom, #c8a97e, #a0784a);
    border-radius: 4px;
    border-bottom: 12px solid #7a5430;
    box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    min-height: 180px;
}
.bookshelf-row::before {
    content: '';
    position: absolute;
    bottom: -28px;
    left: -10px;
    right: -10px;
    height: 20px;
    background: linear-gradient(to bottom, #5c3b1a, #3d2510);
    border-radius: 0 0 6px 6px;
    box-shadow: 0 6px 12px rgba(0,0,0,0.3);
}

/* --- Book Card --- */
.book-card {
    width: 110px;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    flex-shrink: 0;
}
.book-card:hover {
    transform: translateY(-12px) scale(1.05);
}
.book-cover-wrap {
    width: 110px;
    height: 150px;
    border-radius: 2px 6px 6px 2px;
    overflow: hidden;
    box-shadow: -4px 4px 10px rgba(0,0,0,0.4), inset -3px 0 6px rgba(0,0,0,0.15);
    position: relative;
    background: #1a3a6c;
}
.book-cover-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.book-cover-wrap .book-spine {
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 12px;
    background: rgba(0,0,0,0.2);
    border-right: 1px solid rgba(255,255,255,0.1);
}
.book-cover-wrap .no-cover {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #1565c0, #0d47a1);
    color: #fff;
    font-size: 11px;
    text-align: center;
    padding: 8px;
    font-weight: 600;
    line-height: 1.4;
}
.book-title {
    font-size: 11px;
    color: #3d2510;
    font-weight: 600;
    text-align: center;
    margin-top: 8px;
    line-height: 1.3;
    max-height: 2.6em;
    overflow: hidden;
}
.book-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(13, 71, 161, 0.0);
    transition: background 0.3s ease;
    border-radius: 2px 6px 6px 2px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.book-card:hover .book-overlay {
    background: rgba(13, 71, 161, 0.5);
}
.book-overlay span {
    color: #fff;
    font-size: 11px;
    font-weight: bold;
    opacity: 0;
    transition: opacity 0.3s ease;
}
.book-card:hover .book-overlay span {
    opacity: 1;
}

/* --- Flipbook Viewer Modal --- */
.flipbook-modal-overlay {
    display: none;
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.85);
    z-index: 9999;
    align-items: center;
    justify-content: center;
}
.flipbook-modal-overlay.active {
    display: flex;
}
.flipbook-modal {
    background: #1a1a2e;
    border-radius: 12px;
    width: 90vw;
    max-width: 1000px;
    height: 88vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    box-shadow: 0 25px 60px rgba(0,0,0,0.6);
}
.flipbook-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    background: #0d47a1;
    border-radius: 12px 12px 0 0;
}
.flipbook-modal-header h4 {
    color: #fff;
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    flex: 1;
    padding-right: 10px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.flipbook-modal-header .btn-close-flipbook {
    background: rgba(255,255,255,0.2);
    border: none;
    color: #fff;
    font-size: 18px;
    line-height: 1;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    cursor: pointer;
    transition: background 0.2s;
    flex-shrink: 0;
}
.flipbook-modal-header .btn-close-flipbook:hover {
    background: rgba(255,255,255,0.4);
}
.flipbook-modal-toolbar {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 10px 20px;
    background: #16213e;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    flex-wrap: wrap;
}
.flipbook-modal-toolbar button {
    background: #0d47a1;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 6px 14px;
    font-size: 13px;
    cursor: pointer;
    transition: background 0.2s;
}
.flipbook-modal-toolbar button:hover {
    background: #1565c0;
}
.flipbook-modal-toolbar .page-info {
    color: #aaa;
    font-size: 13px;
    min-width: 100px;
    text-align: center;
}
.flipbook-canvas-wrap {
    flex: 1;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #0f0f1a;
    position: relative;
}
.flipbook-pages-container {
    display: flex;
    gap: 4px;
    align-items: center;
    justify-content: center;
    height: 100%;
    transition: opacity 0.3s ease;
}
.flipbook-canvas-wrap canvas {
    box-shadow: 0 0 20px rgba(0,0,0,0.5);
    max-height: 100%;
    border-radius: 2px;
    display: block;
}
.flipbook-download-link {
    display: block;
    text-align: center;
    padding: 10px;
    background: #16213e;
    color: #42a5f5;
    font-size: 13px;
    text-decoration: none;
    border-top: 1px solid rgba(255,255,255,0.1);
}
.flipbook-download-link:hover { color: #90caf9; text-decoration: none; }
.flipbook-loading {
    position: absolute;
    color: #888;
    font-size: 14px;
}
</style>

<?php if ($action === 'view' && $book_id > 0): 
    $buku = $koneksi_db->sql_fetchrow($koneksi_db->sql_query("SELECT * FROM mod_data_flipbook WHERE id='$book_id' AND status='1'"));
    if (!$buku): ?>
        <div class="container" style="padding:50px 0;text-align:center;">
            <p>Buku tidak ditemukan.</p>
            <a href="index.php?pilih=flipbook&modul=yes">Kembali ke Daftar</a>
        </div>
    <?php else: ?>
        <!-- Inline viewer - open specific book -->
        <script>
        window.onload = function() {
            openFlipbook(
                '<?php echo htmlspecialchars($buku['file_pdf']); ?>',
                '<?php echo htmlspecialchars($buku['judul']); ?>'
            );
        };
        </script>
    <?php endif; ?>
<?php endif; ?>

<!-- ===================== BOOKSHELF TAMPILAN ===================== -->
<div class="flipbook-page">
    <div class="container">
        <div class="flipbook-section-header">
            <div class="label-top">Pedoman</div>
            <h2>PEDOMAN MBKM IAI PI BANDUNG</h2>
        </div>
    </div>

    <div class="bookshelf-wrapper">
        <div class="container">
            <?php
            // Ambil semua buku dari DB
            $all_books = [];
            $q = $koneksi_db->sql_query("SELECT * FROM mod_data_flipbook WHERE status='1' ORDER BY ordering ASC, id DESC");
            while ($bk = $koneksi_db->sql_fetchrow($q)) {
                $all_books[] = $bk;
            }

            if (empty($all_books)) {
                echo '<p style="text-align:center; color:#888; padding:40px 0;">Belum ada buku yang tersedia.</p>';
            } else {
                // Split per baris (6 buku per rak)
                $per_row = 6;
                $chunks = array_chunk($all_books, $per_row);
                foreach ($chunks as $row_books) {
                    echo '<div class="bookshelf-row">';
                    foreach ($row_books as $bk) {
                        $cover = !empty($bk['cover']) ? 'images/flipbook/' . htmlspecialchars($bk['cover']) : '';
                        $judul = htmlspecialchars($bk['judul']);
                        $pdf   = htmlspecialchars($bk['file_pdf']);
                        echo '
                        <div class="book-card" onclick="openFlipbook(\'' . $pdf . '\', \'' . addslashes($judul) . '\')">
                            <div class="book-cover-wrap">
                                <div class="book-spine"></div>';
                        if ($cover) {
                            echo '<img src="' . $cover . '" alt="' . $judul . '">';
                        } else {
                            echo '<div class="no-cover">' . $judul . '</div>';
                        }
                        echo '<div class="book-overlay"><span>&#128214; Buka</span></div>
                            </div>
                            <div class="book-title">' . $judul . '</div>
                        </div>';
                    }
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</div>

<!-- ===================== FLIPBOOK VIEWER MODAL ===================== -->
<div class="flipbook-modal-overlay" id="flipbookOverlay">
    <div class="flipbook-modal">
        <div class="flipbook-modal-header">
            <h4 id="flipbookTitle">Judul Buku</h4>
            <button class="btn-close-flipbook" onclick="closeFlipbook()" title="Tutup">&times;</button>
        </div>
        <div class="flipbook-modal-toolbar">
            <button onclick="prevPage()">&#9664; Prev</button>
            <button onclick="prevSpread()">&#171; 2 Hal</button>
            <span class="page-info" id="pageInfo">Hal 1 / 1</span>
            <button onclick="nextSpread()">2 Hal &#187;</button>
            <button onclick="nextPage()">Next &#9654;</button>
            <button onclick="zoomIn()">&#43; Zoom</button>
            <button onclick="zoomOut()">&#8722; Zoom</button>
        </div>
        <div class="flipbook-canvas-wrap" id="flipbookCanvasWrap">
            <div class="flipbook-pages-container" id="pagesContainer">
                <canvas id="canvasLeft"></canvas>
                <canvas id="canvasRight"></canvas>
            </div>
            <div class="flipbook-loading" id="flipbookLoading">Memuat dokumen...</div>
        </div>
        <a href="#" id="flipbookDownload" class="flipbook-download-link" target="_blank">
            &#11015; Download PDF
        </a>
    </div>
</div>

<!-- PDF.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

let pdfDoc = null;
let currentPage = 1;
let totalPages = 0;
let scale = 1.2;
let isSpread = true; // show 2 pages side by side

function openFlipbook(pdfUrl, title) {
    document.getElementById('flipbookTitle').textContent = title;
    document.getElementById('flipbookDownload').href = pdfUrl;
    document.getElementById('flipbookOverlay').classList.add('active');
    document.getElementById('flipbookLoading').style.display = 'block';
    document.getElementById('pagesContainer').style.opacity = '0';
    currentPage = 1;

    pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
        pdfDoc = pdf;
        totalPages = pdf.numPages;
        document.getElementById('flipbookLoading').style.display = 'none';
        document.getElementById('pagesContainer').style.opacity = '1';
        renderSpread(currentPage);
    }).catch(function(err) {
        document.getElementById('flipbookLoading').textContent = 'Gagal memuat PDF. Periksa koneksi & path file.';
        console.error(err);
    });
}

function closeFlipbook() {
    document.getElementById('flipbookOverlay').classList.remove('active');
    pdfDoc = null;
    var c1 = document.getElementById('canvasLeft');
    var c2 = document.getElementById('canvasRight');
    var ctx1 = c1.getContext('2d');
    var ctx2 = c2.getContext('2d');
    ctx1.clearRect(0, 0, c1.width, c1.height);
    ctx2.clearRect(0, 0, c2.width, c2.height);
}

function renderPage(pageNum, canvasId) {
    if (!pdfDoc || pageNum < 1 || pageNum > totalPages) {
        var canvas = document.getElementById(canvasId);
        canvas.style.display = 'none';
        return Promise.resolve();
    }
    return pdfDoc.getPage(pageNum).then(function(page) {
        var viewport = page.getViewport({ scale: scale });
        var canvas = document.getElementById(canvasId);
        canvas.style.display = 'block';
        canvas.height = viewport.height;
        canvas.width = viewport.width;
        return page.render({ canvasContext: canvas.getContext('2d'), viewport: viewport }).promise;
    });
}

function renderSpread(leftPage) {
    if (!pdfDoc) return;
    // Left page
    renderPage(leftPage, 'canvasLeft');
    // Right page (next)
    if (isSpread && leftPage + 1 <= totalPages) {
        renderPage(leftPage + 1, 'canvasRight');
    } else {
        document.getElementById('canvasRight').style.display = 'none';
    }
    var displayRight = (isSpread && leftPage + 1 <= totalPages) ? leftPage + 1 : leftPage;
    document.getElementById('pageInfo').textContent = 'Hal ' + leftPage + (isSpread && leftPage + 1 <= totalPages ? '-' + (leftPage + 1) : '') + ' / ' + totalPages;
}

function nextPage() {
    if (!pdfDoc) return;
    if (currentPage < totalPages) { currentPage++; renderSpread(currentPage); }
}
function prevPage() {
    if (!pdfDoc) return;
    if (currentPage > 1) { currentPage--; renderSpread(currentPage); }
}
function nextSpread() {
    if (!pdfDoc) return;
    var step = isSpread ? 2 : 1;
    if (currentPage + step <= totalPages) { currentPage += step; renderSpread(currentPage); }
}
function prevSpread() {
    if (!pdfDoc) return;
    var step = isSpread ? 2 : 1;
    if (currentPage - step >= 1) { currentPage -= step; renderSpread(currentPage); }
}
function zoomIn() { scale += 0.2; if (pdfDoc) renderSpread(currentPage); }
function zoomOut() { if (scale > 0.4) { scale -= 0.2; if (pdfDoc) renderSpread(currentPage); } }

// Close on overlay click
document.getElementById('flipbookOverlay').addEventListener('click', function(e) {
    if (e.target === this) closeFlipbook();
});

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (!document.getElementById('flipbookOverlay').classList.contains('active')) return;
    if (e.key === 'ArrowRight') nextPage();
    if (e.key === 'ArrowLeft') prevPage();
    if (e.key === 'Escape') closeFlipbook();
});
</script>
