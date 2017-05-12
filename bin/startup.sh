<<<<<<< HEAD
#!/usr/bin/env bash
set -e

/etc/shibboleth/shibd-redhat start

rm -f /usr/local/apache2/logs/httpd.pid
exec httpd -DFOREGROUND
=======
rm -f /usr/local/apache2/logs/httpd.pid
exec httpd -DFOREGROUND
>>>>>>> f68ce6b03b2d478527bb7ffe2733a0d3b42522c2
