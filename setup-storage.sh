#!/bin/bash

# Setup Storage Symbolic Link for Flower Store
# This script creates the symbolic link and sets proper permissions

echo "========================================"
echo "Flower Store - Storage Setup"
echo "========================================"
echo ""

# Create symbolic link
echo "Creating storage symbolic link..."
php artisan storage:link

if [ $? -eq 0 ]; then
    echo ""
    echo "Setting proper permissions..."
    chmod -R 775 storage bootstrap/cache
    
    echo ""
    echo "========================================"
    echo "SUCCESS!"
    echo "========================================"
    echo "Storage symbolic link created successfully."
    echo "Permissions set correctly."
    echo "Images can now be uploaded and displayed."
    echo ""
else
    echo ""
    echo "========================================"
    echo "ERROR!"
    echo "========================================"
    echo "Failed to create symbolic link."
    echo ""
    echo "Troubleshooting:"
    echo "1. Make sure PHP is installed and in your PATH"
    echo "2. Check that Laravel is properly installed"
    echo "3. Verify you have write permissions"
    echo ""
fi


