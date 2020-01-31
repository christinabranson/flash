FROM webdevops/php-apache-dev
RUN echo "short_open_tag=On" >> /opt/docker/etc/php/php.ini
RUN mkdir /var/lib/php/session
RUN chown -R application:ftp /var/lib/php/session
#RUN yum install -y sshpass
#ADD dbimport.sh /opt/dbimport.sh
#RUN chmod 777 /opt/dbimport.sh
#ADD dbimport.sh /opt/dbimport.sh
