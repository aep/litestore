init: restore.db

restore.db:
	(echo 'select nazi from fish;' | sqlite3 -batch restore.db) || (  rm restore.db ; exit 1  )
