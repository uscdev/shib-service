rm -f /usr/local/apache2/logs/httpd.pid
exec httpd -DFOREGROUND
