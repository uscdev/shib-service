FROM uscdev/centos

# Thanks jtgasper3/centos-shibboleth-sp
MAINTAINER Don Corley <dcorley@usc.edu>

ENV USC_CENTOS_VERSION 7.4.0
ENV SHIB_VERSION=2.61
ENV APACHE_VERSION=

RUN yum -y update \
    && yum -y install httpd mod_ssl \
 	&& yum -y install openssl wget
# RUN yum -y upgrade # Not required since base image is always patched

RUN echo -e "\
[shibboleth]\n\
name=Shibboleth (CentOS_7)\n\
type=rpm-md\n\
mirrorlist=https://shibboleth.net/cgi-bin/mirrorlist.cgi/CentOS_7\n\
gpgcheck=1\n\
gpgkey=https://downloadcontent.opensuse.org/repositories/security:/shibboleth/CentOS_7/repodata/repomd.xml.key\n\
enabled=1" > /etc/yum.repos.d/shibboleth.repo

RUN yum -y install shibboleth-2.6.1-3.1.x86_64 \
    && yum -y clean all
# RUN yum -y install shibboleth.x86_64 \
#    && yum -y clean all
# RUN wget http://download.opensuse.org/repositories/security://shibboleth/CentOS_7/security:shibboleth.repo -P /etc/yum.repos.d \
#    && yum -y install shibboleth.x86_64 \
#    && yum -y clean all

RUN test -d /var/run/lock || mkdir -p /var/run/lock \
    && test -d /var/lock/subsys/ || mkdir -p /var/lock/subsys/ \
    && chmod +x /etc/shibboleth/shibd-redhat \
    && echo $'export LD_LIBRARY_PATH=/opt/shibboleth/lib64:$LD_LIBRARY_PATH\n'\
       > /etc/sysconfig/shibd \
    && chmod +x /etc/sysconfig/shibd

COPY config/conf/httpd.conf /etc/httpd/conf/
COPY config/conf.d/ssl.conf /etc/httpd/conf.d/

COPY bin/startup.sh /usr/local/bin/

COPY config/shibboleth-sp/attribute-map.xml /etc/shibboleth/
COPY config/shibboleth-sp/attribute-policy.xml /etc/shibboleth/
COPY config/shibboleth-sp/shibboleth2.xml /etc/shibboleth/
COPY config/shibboleth-sp/USC-metadata.xml /etc/shibboleth/
COPY config/conf.d/shib.conf /etc/httpd/conf.d/

COPY html/unprotected /var/www/html/unprotected

EXPOSE 80 443

CMD ["startup.sh"]
