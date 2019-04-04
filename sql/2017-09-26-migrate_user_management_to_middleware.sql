#drop reference negara, kota, instansi, komentar

ALTER TABLE users ADD COLUMN name CHARACTER VARYING;

UPDATE users SET name = employees.name FROM employees WHERE employees.id = employee_id;

ALTER TABLE users ADD COLUMN is_external BOOLEAN;