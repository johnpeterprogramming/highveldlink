#!/usr/bin/env bash
set -euo pipefail

# Named volumes (like /app/storage) are created as root-owned.
# Ensure Laravel can write logs/cache when running as www-data.
mkdir -p \
  /app/storage/logs \
  /app/storage/framework/cache/data \
  /app/storage/framework/views \
  /app/storage/framework/sessions \
  /app/bootstrap/cache

chown -R www-data:www-data /app/storage /app/bootstrap/cache || true
chmod -R ug+rwX /app/storage /app/bootstrap/cache || true

# Octane may try to auto-update FrankenPHP by renaming the binary.
# In containers we typically want this disabled.
OCTANE_FRANKENPHP_AUTO_UPDATE="${OCTANE_FRANKENPHP_AUTO_UPDATE:-0}"
case "${OCTANE_FRANKENPHP_AUTO_UPDATE}" in
  0|1) ;;
  true|TRUE|yes|YES|on|ON) OCTANE_FRANKENPHP_AUTO_UPDATE=1 ;;
  false|FALSE|no|NO|off|OFF|"") OCTANE_FRANKENPHP_AUTO_UPDATE=0 ;;
  *) OCTANE_FRANKENPHP_AUTO_UPDATE=0 ;;
esac
export OCTANE_FRANKENPHP_AUTO_UPDATE

exec gosu www-data "$@"
