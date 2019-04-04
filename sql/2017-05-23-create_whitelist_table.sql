CREATE TABLE whitelist(
	id SERIAL,
	ip VARCHAR(15),
	domain VARCHAR,
	keterangan TEXT,
	is_active BOOLEAN
);

INSERT INTO whitelist(ip,keterangan, is_active) VALUES ('*','Aktifkan ini untuk mengizinkan semua IP.', TRUE);