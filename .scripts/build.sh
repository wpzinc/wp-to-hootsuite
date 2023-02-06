# Build ACTIONS-FILTERS.md
php create-actions-filters-docs.php

# Generate .pot file
php -n $(which wp) i18n make-pot ../ ../languages/wp-to-hootsuite.pot

# Build ZIP file, excluding non-Plugin files
cd ..
rm wp-to-hootsuite.zip
zip -r wp-to-hootsuite.zip . \
-x "*.scss" \
-x "*.git*" \
-x ".scripts/*" \
-x "tests/*" \
-x "vendor/*" \
-x "*.distignore" \
-x "*.env.*" \
-x ".gitignore" \
-x "*.md" \
-x "*codeception.*" \
-x "composer.json" \
-x "composer.lock" \
-x "config.codekit3" \
-x "phpcs.tests.xml" \
-x "phpcs.xml" \
-x "*.DS_Store" \
