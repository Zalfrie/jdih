CREATE TABLE jdihn_service_log(
	id BIGSERIAL,
	ip VARCHAR(15),
	date TIMESTAMP DEFAULT NOW(),
	allowed BOOLEAN
);