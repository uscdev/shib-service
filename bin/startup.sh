#!/usr/bin/env bash
set -e

/etc/shibboleth/shibd-redhat start

rm -f /usr/local/apache2/logs/httpd.pid
exec httpd -DFOREGROUND