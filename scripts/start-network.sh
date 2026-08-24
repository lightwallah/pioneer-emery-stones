#!/bin/bash
# Run site on LAN so other devices can test (same Wi‑Fi).
# Usage: ./scripts/start-network.sh

cd "$(dirname "$0")/../public" || exit 1

IP=$(ipconfig getifaddr en0 2>/dev/null || ipconfig getifaddr en1 2>/dev/null)
if [ -z "$IP" ]; then
  IP=$(ifconfig | awk '/inet / && $2 != "127.0.0.1" {print $2; exit}')
fi

PORT=8080
echo ""
echo "Pioneer Emery Stones — network dev server"
echo "  This laptop:  http://localhost:${PORT}/en"
echo "  Other laptop: http://${IP:-YOUR_IP}:${PORT}/en"
echo "  Admin:        http://${IP:-YOUR_IP}:${PORT}/admin/login"
echo ""
echo "Press Ctrl+C to stop."
echo ""

php -S "0.0.0.0:${PORT}" router-dev.php
