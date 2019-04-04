ALTER TABLE per_materi_rel DROP CONSTRAINT per_materi_rel_materi_id_fkey;
ALTER TABLE per_materi_rel ADD CONSTRAINT per_materi_rel_materi_id_fkey FOREIGN KEY (materi_id) REFERENCES public.per_materi_ref (materi_id) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE;
--Jika materi peraturan di-delete, relasi ke peraturan juga ter-delete