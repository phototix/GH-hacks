#!/bin/bash

# 設定要重新啟動的伺服器 IP 地址
server_ip="192.168.1.1"

# 測試伺服器是否可連線
ping -c 1 $server_ip >/dev/null 2>&1
if [ $? -ne 0 ]; then
  echo "伺服器無法連線。"
  exit 1
fi

# 重新啟動伺服器上的服務
sudo systemctl restart httpd
sudo systemctl restart php-fpm
sudo systemctl restart mariadb

# 檢查服務是否已重新啟動成功
for service in httpd php-fpm mariadb; do
  status=$(sudo systemctl status $service)
  if [[ $status =~ "active (running)" ]]; then
    echo "$service 已重新啟動成功。"
  else
    echo "$service 未能重新啟動。"
    exit 1
  fi
done

# 腳本執行成功
echo "腳本執行成功。"