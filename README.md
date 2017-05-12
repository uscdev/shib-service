# shib-service

Base Apache Web Server with USC Shibboleth configuration.

Use this container as a base for your web-based shib-protected applications.

This container is designed to be extended. Create a new container based
on this image and add content in the */var/www/html* directory.
You can find an example [here](https://github.com/uscdev/shib-service-example).

### Usage

1. Create a Dockerfile based on this image and add your code and content

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
docker secret create sp-cert.pem sp-cert.pem
docker secret create sp-cert.key sp-cert.key
docker secret create apache.crt apache.crt
docker secret create apache.key apache.key
````

3. Start up the service using the stack or service command.

````bash
docker stack deploy --compose-file docker-compose.yml app-name
````

4. For production deployments, create a new shib key and mount the
appropriate shib conf files in the ````/etc/shibboleth```` directory.

Note: For microservice implementations,
use [shib-reverse-proxy](https://github.com/uscdev/shib-reverse-proxy).