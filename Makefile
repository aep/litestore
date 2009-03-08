default: make-php db/restore.db

php/php-5.2.9/Makefile:
	cd php/php-5.2.9;./configure --enable-sqlite-utf8 --enable-memory-limit --enable-force-cgi-redirect --enable-track-vars --with-pcre-regex --without-mm --enable-fastcgi --prefix=/srv/http/restore/php

make-php: php/php-5.2.9/Makefile
	cd php/php-5.2.9;make



db/restore.db : 
	cd db;make

install:
	install -o http -d /srv/http/restore 
	cp . /srv/http/restore -av
	cd php/php-5.2.9;make install 

	

