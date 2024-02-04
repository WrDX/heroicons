#!/usr/bin/env bash

# Make sure we're in the right directory
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
BASEDIR="${SCRIPT_DIR}/../"
cd "${BASEDIR}" || exit

# Reset resources directory
echo "Resetting resources directory"

if [ -d "${BASEDIR}/resources/heroicons" ]; then
  rm -Rf "${BASEDIR}/resources/heroicons"
fi
mkdir -p "${BASEDIR}/resources/heroicons"

# Pull heroicons/optimized directory
echo "Fetching heroicons git repo"

cd "${BASEDIR}/resources/heroicons" || exit

git init -b main -q
git remote add -f origin https://github.com/tailwindlabs/heroicons.git &> /dev/null
git config core.sparseCheckout true
echo "/optimized/" >> .git/info/sparse-checkout
git fetch --tags
latestTag=$(git describe --tags "$(git rev-list --tags --max-count=1)")

# Check out latest release
echo "Checking out ${latestTag}"

git checkout -q "${latestTag}"

# Note version in .version
echo "${latestTag}" > "${BASEDIR}/resources/heroicons/.version"

# Remove heroicons .git dir
echo "Removing heroicons .git directory"

rm -Rf .git

echo "Updated heroicon svg files to latest version"
