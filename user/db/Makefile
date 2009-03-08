default:  migrate


current:
	@echo "0" >  current 



MIGRATEFILES :=  $(patsubst %.sql,%.sql.migrate,$(wildcard *.sql))


migrate: current $(MIGRATEFILES)
	@echo "current is" $$(cat current)

%.sql.migrate:
	@i=$@;\
	f=$${i%%.*}; \
	if test $$f -gt $$(cat current); then \
		echo "migrating "$$f; \
		sqlite3 -batch restore.db  < $$f.sql 2>/dev/null ; \
		echo $$f > current;\
	fi

drop: 
	rm -f current restore.db

