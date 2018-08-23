# shib-service

NOTE: Fix the Dockerfile shib repo setup. I had to hack this
to supply a static repo entry rather that using the correct
command due to a bug in the current shib repo.

Base Apache Web Server with USC Shibboleth configuration.

Use this container as a base for your web-based shib-protected applications.
This container is tagged on docker hub as [uscdev/shib-service](https://hub.docker.com/r/uscdev/shib-service/).

This container is designed to be extended. Create a new container based
on this image and add content in the */var/www/html* directory.
You can find an example [here](https://github.com/uscdev/shib-service-example).

### Usage

1. Create a Dockerfile based on this image. Add your code and content

````dockerfile
FROM uscdev/shib-service
RUN yum -y install php php-mysql
COPY html /var/www/html/
````

2. Install your ssl and shib keys as secrets

Note: Find the instructions for configuring USC shib [here](https://shibboleth.usc.edu/).
You must add the ssl cert for http access. Self signed certs are fine.
The test shib keys for the USC test instance are located
in the container at */etc/shibboleth/sp-cert.key* and */etc/shibboleth/sp-cert.pem*.
You can copy them out of the container by using the Docker cp command:
````docker cp [container-id]:/etc/shibboleth/sp-cert.pem ./````

Add the secrets to your swarm:

````bash
docker swarm init   # Only do this once
docker secret create sp-cert.pem sp-cert.pem
docker secret create sp-cert.key sp-cert.key
docker secret create apache.crt apache.crt
docker secret create apache.key apache.key
````

3. Start up the service using the stack or service command.

````bash
docker stack deploy --compose-file docker-compose.yml app-name
````

4. Bring up the sample web page: <http://localhost>. Note that apache will auto-forward
the URL to https. Also you will be redirected to the USC test shib sign-on. Click the 
attribute link to see the Shib parameters passed to the app.

5. For production deployments, create a new shib key and mount the
appropriate shib conf files in the ````/etc/shibboleth```` directory.

#### To use shib-service as a reverse-proxy, pass the PROXY_URL parameter
#### To enable the WebSocket proxy, set the WEBSOCKET_URL parameter.
#### To enable a path to an alternate container, use ALT_PROXY_URL 
docker-compose snippet:
````dockerfile
    environment:
      - SERVER_NAME=${SERVER_NAME}
      - PROXY_URL=http://shib-test-site/
      - WEBSOCKET_URL=ws://shib-test-site/
      - ALT_PROXY_PATH=/backend_express
      - ALT_PROXY_URL=http://shib-test-site2/backend_express
      
````

Remember to pass parameters to the proxy using mod rewrite (in the ssl.conf file):
````bash
RewriteEngine on

RewriteCond %{ShibdisplayName} (.*)
RewriteRule ^ - [E=ShibdisplayName:%{LA-U:ShibdisplayName}]
RequestHeader set Shibmail %{ShibdisplayName}e
````

Note: If you prefer NGINX, Use this microservice implementation:
 [shib-reverse-proxy](https://github.com/uscdev/shib-reverse-proxy).

Note: Any pages that don't require shib should go into the ````unprotected```` folder.
This implementation includes a health check page at: https://&lt;host&gt;/unprotected/health.html 

#### Health

This container has a built-in healthcheck.
You can do a external healthcheck by requesting `https://yoursite.com/Shibboleth.sso/Session`.
If you receive "A valid session was not found." you are good.
You should add a healthcheck to your container.
Since the path `/unprotected/health.html` is not shib protected, you should use the following healthcheck:

````
HEALTHCHECK CMD curl -f http://localhost/unprotected/health.html || exit 1
````