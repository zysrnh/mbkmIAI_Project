
CREATE TABLE IF NOT EXISTS `mod_data_flipbook` (
  `id`        INT(11) NOT NULL AUTO_INCREMENT,
  `judul`     VARCHAR(255) NOT NULL,
  `deskripsi` TEXT,
  `cover`     VARCHAR(255) DEFAULT NULL COMMENT 'nama file gambar cover di images/flipbook/',
  `file_pdf`  VARCHAR(255) NOT NULL COMMENT 'path relatif: files/flipbook/namafile.pdf',
  `kategori`  VARCHAR(100) DEFAULT '' COMMENT 'Contoh: Magang, Pertukaran, KKNT, dll',
  `ordering`  INT(5) DEFAULT 0,
  `status`    TINYINT(1) DEFAULT 1 COMMENT '1=aktif, 0=nonaktif',
  `tanggal`   DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='E-Book Pedoman MBKM IAI PI Bandung';