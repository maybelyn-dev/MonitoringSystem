#!/bin/bash
# RAMS Region III - Setup Script
# Run this script to set up the entire system

echo "🚀 RAMS Region III - Setup Script"
echo "=================================="
echo ""

# Step 1: Install Dependencies
echo "📦 Step 1: Installing dependencies..."
composer install
npm install
echo "✅ Dependencies installed"
echo ""

# Step 2: Environment Setup
echo "⚙️  Step 2: Setting up environment..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✅ .env file created"
else
    echo "✅ .env file already exists"
fi

php artisan key:generate
echo "✅ Application key generated"
echo ""

# Step 3: Database Setup
echo "🗄️  Step 3: Setting up database..."
php artisan migrate
echo "✅ Migrations completed"

php artisan db:seed
echo "✅ Database seeded with agencies and test users"
echo ""

# Step 4: Build Assets
echo "🎨 Step 4: Building assets..."
npm run build
echo "✅ Assets built"
echo ""

# Step 5: Summary
echo "=================================="
echo "✅ Setup Complete!"
echo "=================================="
echo ""
echo "📝 Next Steps:"
echo "1. Start the development server:"
echo "   php artisan serve"
echo ""
echo "2. Visit the application:"
echo "   http://localhost:8000"
echo ""
echo "3. Test Credentials:"
echo "   Email: dict@example.com"
echo "   Password: password"
echo "   Agency: DICT Region III"
echo ""
echo "📚 Documentation:"
echo "   - SETUP.md - Complete setup guide"
echo "   - IMPLEMENTATION.md - Technical details"
echo "   - QUICK_REFERENCE.md - Quick lookup"
echo "   - CHECKLIST.md - Feature checklist"
echo ""
echo "🎉 Happy monitoring!"
