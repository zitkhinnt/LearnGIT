#!/bin/sh
mysqldump -u root channel > /data/backup/db_cn_$(date +%Y-%m-%d.%H:%M).sql
find /data/backup/ -mtime +3 -type f -delete
