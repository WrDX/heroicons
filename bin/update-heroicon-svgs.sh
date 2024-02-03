#!/usr/bin/env bash

# Make sure we're in the right directory
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
cd "$SCRIPT_DIR/../" || exit

# Reset resources directory
echo "Resetting resources directory"

if [ -d "./resources/heroicons" ]; then
  rm -Rf "./resources/heroicons"
fi
mkdir -p "./resources/heroicons"
cd "./resources/heroicons" || exit

# Pull heroicons/optimized directory
echo "Fetching heroicons git repo"

git init -b main -q
git remote add -f origin https://github.com/tailwindlabs/heroicons.git &> /dev/null
git config core.sparseCheckout true
echo "/optimized/" >> .git/info/sparse-checkout
git fetch --tags
latestTag=$(git describe --tags "$(git rev-list --tags --max-count=1)")

# Check out latest release
echo "Checking out ${latestTag}"

git checkout -q "${latestTag}"

# Remove heroicons .git dir
echo "Removing heroicons .git directory"

rm -Rf .git

echo "Updated heroicon svg files to latest version"
