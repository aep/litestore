default:  migrate


current:
	echo "0" >  current 

migrate: current 
	@echo "migrating";
	@echo "current is" $$(cat current) 
	@for i in *.sql;do \
	f=$${i%%.*}; \
	if test $$f -gt $$(cat current); then \
		echo "   "$$f; \
		sqlite3 -batch restore.db  < $$i ; \
		echo $$f > current;\
	fi; \
	done




#	( sqlite3 -batch restore.db  < ../build/restore.sql  ) || (  rm restore.db ; exit 1  )



drop: 
	rm -f current restore.db
