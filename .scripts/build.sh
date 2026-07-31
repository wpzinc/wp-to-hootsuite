# Remove vendor directory
cd ..
rm -rf vendor

# Run composer to only install non-dev dependencies
composer install --no-dev

# Build ZIP file, excluding non-Plugin files
rm wp-to-hootsuite.zip
zip -r wp-to-hootsuite.zip . \
-x "*.git*" \
-x ".devcontainer/*" \
-x ".scripts/*" \
-x ".wordpress-org/*" \
-x "node_modules/*" \
-x "log/*" \
-x "tests/*" \
-x "vendor/*" \
-x "*.distignore" \
-x "*.env.*" \
-x "*.md" \
-x "*.yml" \
-x "*.xml" \
-x "*.neon" \
-x "*.dist" \
-x "*.example" \
-x "*.DS_Store" \
-x ".gitignore" \
-x ".eslintrc.js" \
-x ".stylelintrc.json" \
-x "composer.json" \
-x "composer.lock" \
-x "package.json" \
-x "package-lock.json" \

# Run composer to install dev dependencies, returning enviornment back to original state
composer update