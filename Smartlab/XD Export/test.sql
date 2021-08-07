-- -----------------------------------------------------
-- Table `akses_levels`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `akses_levels` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `akses_levels` (
  `id` INT(3) UNSIGNED NOT NULL,
  `jabatan` VARCHAR(191) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `aktivitas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `aktivitas` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `aktivitas` (
  `id` INT(3) NOT NULL,
  `aktivitas` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `data_sampels`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `data_sampels` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `data_sampels` (
  `id` INT(6) NOT NULL,
  `parameter_id` VARCHAR(191) NULL,
  `jenis_sampel_id` INT(3) NOT NULL,
  `pelanggans_id` INT(4) NOT NULL,
  `pakets_id` INT(5) NOT NULL,
  `tanggal_masuk` DATETIME NULL,
  `tanggal_selesai` INT(11) NULL,
  `nomor_surat` VARCHAR(191) NULL,
  `perusahaan` VARCHAR(191) NULL,
  `jumlah_sampel` INT(11) NULL,
  `status` VARCHAR(191) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `detail_trackings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `detail_trackings` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `detail_trackings` (
  `aktivitas_waktu` DATETIME NULL,
  `data_sampels_id` INT(6) NOT NULL,
  `aktivitas_id` INT NOT NULL,
  `lab_akuns_id` INT(3) NOT NULL)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `hasil_analisas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hasil_analisas` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `hasil_analisas` (
  `id` INT(6) NOT NULL,
  `tahun` VARCHAR(2) NULL,
  `no_lab` INT(11) NULL,
  `kode_contoh` VARCHAR(45) NULL,
  `petugas_id` TEXT NULL,
  `hasil` TEXT NULL,
  `status` ENUM('0', '1') NULL,
  `retry` INT NULL,
  `jenis_sampel_id` INT(3) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `jenis_sampels`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `jenis_sampels` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `jenis_sampels` (
  `id` INT(3) NOT NULL,
  `jenis_sampel` VARCHAR(45) NULL,
  `lambang_sampel` VARCHAR(4) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `lab_akuns`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lab_akuns` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `lab_akuns` (
  `id` INT(3) NOT NULL AUTO_INCREMENT,
  `metodes_id` INT NOT NULL,
  `akses_levels_id` INT(3) UNSIGNED NOT NULL,
  `nama` VARCHAR(100) NULL,
  `email` VARCHAR(191) NULL,
  `password` VARCHAR(191) NULL,
  `jabatan` VARCHAR(45) NULL,
  `status_akun` ENUM('0', '1') NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `metodes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `metodes` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `metodes` (
  `id` INT(5) NOT NULL,
  `metode` VARCHAR(45) NULL,
  `pengukuran` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `pakets`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pakets` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `pakets` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `jenis_sampels_id` INT(3) NOT NULL,
  `paket` VARCHAR(45) NULL,
  `parameter` VARCHAR(45) NULL,
  `harga` INT(11) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `parameters`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `parameters` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `parameters` (
  `id` INT NOT NULL,
  `simbol` VARCHAR(4) NULL,
  `nama_unsur` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `pelanggans`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pelanggans` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `pelanggans` (
  `id` INT(4) NOT NULL,
  `email` VARCHAR(191) NULL,
  `password` VARCHAR(191) NULL,
  `nama` VARCHAR(100) NULL,
  `perusahaan` VARCHAR(45) NULL,
  `nomor_telepon` VARCHAR(20) NULL,
  `alamat` TEXT NULL,
  `tanggal_registrasi` DATE NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
