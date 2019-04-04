ALTER TABLE per_0_tm
  ADD COLUMN review_start TIMESTAMP;

ALTER TABLE per_0_tm
  ADD COLUMN review_end TIMESTAMP;

ALTER TABLE per_0_tm
  ADD COLUMN is_reviewed BOOLEAN DEFAULT FALSE;

INSERT INTO uncategorized_post(post_type, content)
  VALUES ('mukadimah_program_prepare', 'Bagian ini berisi penjelasan mengenai Program PREPARE BUMN');

ALTER TABLE per_review ALTER COLUMN review_at SET DEFAULT now();

ALTER TABLE per_review ADD COLUMN file_id integer;