#!/usr/bin/env bash

echo "Checking newest version of tailwindlabs/heroicons..."

# Move to basedir
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
BASEDIR="${SCRIPT_DIR}/.."
cd "${BASEDIR}/" || exit

# Read current version
currentVersion="0"
if [ -f "${BASEDIR}/resources/heroicons/.version" ]; then
  currentVersion=$(cat "${BASEDIR}/resources/heroicons/.version")
fi

# Create a tmp dir to do stuff
if [ -d "${BASEDIR}/.tmp" ]; then
  rm -Rf "${BASEDIR}/.tmp"
fi
mkdir -p "${BASEDIR}/.tmp"
cd "${BASEDIR}/.tmp/" || exit

# Fetch tailwindlabs/heroicons to check latest version

git init -b main -q
git remote add -f origin https://github.com/tailwindlabs/heroicons.git &> /dev/null
git config core.sparseCheckout true
echo "/optimized/" >> .git/info/sparse-checkout
git fetch --tags
latestVersion=$(git describe --tags "$(git rev-list --tags --max-count=1)")

# Check if already on latestVersion
if [[ "${currentVersion}" == "${latestVersion}"  ]]; then
  echo "Already on latest version (${latestVersion}). To force a re-install, delete resources/heroicons".
  exit
fi

# Install latestVersion

if [ "${currentVersion}" == "0" ]; then
  echo "Installing heroicon svg files ${latestVersion}"
else
  echo "Updating heroicon svg files from ${currentVersion} to ${latestVersion}"
fi

# Checkout latest version of tailwindlabs/heroicons
git checkout -q "${latestVersion}"

# Reset resources/heroicons
if [ -d "${BASEDIR}/resources/heroicons" ]; then
  rm -Rf "${BASEDIR}/resources/heroicons"
fi
mkdir -p "${BASEDIR}/resources/heroicons"

# Move svg files to resources
mv "${BASEDIR}/.tmp/optimized/"* "${BASEDIR}/resources/heroicons/"

# Note version in .version
echo "${latestVersion}" > "${BASEDIR}/resources/heroicons/.version"

# Remove .tmp
rm -Rf "${BASEDIR}/.tmp/"

echo "Done!"
