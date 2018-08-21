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

if [ "$ALT_PROXY_URL" != "" ]; then
    sed -i -e "/\#\ BEGINALTREVERSEPROXY/,/\#\ ENDALTREVERSEPROXY/c\\#\ BEGINALTREVERSEPROXY\n\
ProxyPass \"$ALT_PROXY_PATH\" \"$ALT_PROXY_URL\"\n\
ProxyPassReverse \"$ALT_PROXY_PATH\" \"$ALT_PROXY_URL\"\n\
\#\ ENDALTREVERSEPROXY" /etc/httpd/conf.d/ssl.conf
else
    sed -i -e "/\#\ BEGINALTREVERSEPROXY/,/\#\ ENDALTREVERSEPROXY/c\\#\ BEGINALTREVERSEPROXY\n\
\# ProxyPass \"/\" \"http\:\/\/shib-test2\/\"\n\
\# ProxyPassReverse \"/alt\" \"http\:\/\/shib-test2\/\"\n\
\#\ ENDALTREVERSEPROXY" /etc/httpd/conf.d/ssl.conf
fi

if [ "$WEBSOCKET_URL" != "" ]; then
    sed -i -e "/\#\ BEGINWEBSOCKET/,/\#\ ENDWEBSOCKET/c\\#\ BEGINWEBSOCKET\n\
RewriteCond \%\{HTTP\:Upgrade\} \=websocket \[NC\]\n\
RewriteRule \/\(\.\*\) $WEBSOCKET_URL\$1 \[P,L\]\n\
\#\ ENDWEBSOCKET" /etc/httpd/conf.d/ssl.conf
else
    sed -i -e "/\#\ BEGINWEBSOCKET/,/\#\ ENDWEBSOCKET/c\\#\ BEGINWEBSOCKET\n\
\# RewriteCond \%\{HTTP\:Upgrade\} \=websocket \[NC\]\n\
\# RewriteRule \/\(\.\*\) ws\:\/\/shib-test/\$1 \[P,L\]\n\
\#\ ENDWEBSOCKET" /etc/httpd/conf.d/ssl.conf
fi

/etc/shibboleth/shibd-redhat start

rm -f /usr/local/apache2/logs/httpd.pid
exec httpd -DFOREGROUND
