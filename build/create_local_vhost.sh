if test "" = "$1"
then
  echo "usage: $0 ltsroot"
  exit 5
fi

if test ! -x $1/app/pub/index.php
then 
  echo "$1  doesn't look like a litestore"
  exit
fi




sed "s;{{CORE_ROOT}};$1;" < vhost |  sed  "s;{{USER_ROOT}};$1/user;"

