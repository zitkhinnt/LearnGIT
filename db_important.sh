#!/bin/sh
mysqldump -u root channel prediction transaction_payment users > /data/backup/db_cn_important_$(date +%Y-%m-%d.%H:%M).sql
find /data/backup/ -mtime +3 -type f -delete
