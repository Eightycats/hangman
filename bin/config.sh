#!/bin/sh

sudo cat slim.conf >> /etc/nginx/conf.d/elasticbeanstalk/php.conf

sudo service nginx reload
