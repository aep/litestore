if test "" = "$1"
then
  echo "usage: $0 username > /etc/httpd/conf/vhosts/username"
  exit 5
fi


sed "s;{{CORE_ROOT}};/srv/http/litestore/;" < vhost |  sed  "s;{{USER_ROOT}};/www/$1;" 

