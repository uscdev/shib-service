#!/usr/bin/env bash
set -e

if [ "$PROXY_URL" != "" ]; then
    sed -i -e "/\#\ BEGINREVERSEPROXY/,/\#\ ENDREVERSEPROXY/c\\#\ BEGINREVERSEPROXY\n\
    ProxyPass \"/\" \"$PROXY_URL\"\n\
    ProxyPassReverse \"/\" \"$PROXY_URL\"\n\
    \#\ ENDREVERSEPROXY" /etc/httpd/conf.d/ssl.conf
else
    sed -i -e "/\#\ BEGINREVERSEPROXY/,/\#\ ENDREVERSEPROXY/c\\#\ BEGINREVERSEPROXY\n\
    \# ProxyPass \"/\" \"http\:\/\/shib-test\/\"\n\
    \# ProxyPassReverse \"/\" \"http\:\/\/shib-test\/\"\n\
    \#\ ENDREVERSEPROXY" /etc/httpd/conf.d/ssl.conf
fi

/etc/shibboleth/shibd-redhat start

rm -f /usr/local/apache2/logs/httpd.pid
exec httpd -DFOREGROUND
