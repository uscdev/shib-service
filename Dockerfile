FROM uscdev/centos:7.3.1

MAINTAINER Don Corley <dcorley@usc.edu>

RUN yum -y update \
    && yum -y install httpd

COPY bin/startup.sh /startup.sh

EXPOSE 80 443

CMD ["startup.sh"]
