# Contributing to Kedai

Thank you for your interest in contributing to Kedai! This document provides guidelines for contributing to the project.

## Code of Conduct

By participating in this project, you agree to maintain a respectful and collaborative environment.

## Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js & NPM
- Git

### Development Setup

1. Fork the repository
2. Clone your fork:
   ```bash
   git clone https://github.com/YOUR_USERNAME/kedai.git
   cd kedai
   ```

3. Install dependencies:
   ```bash
   composer install
   npm install
   ```

4. Set up environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure database in `.env`

6. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

7. Create a new branch:
   ```bash
   git checkout -b feature/your-feature-name
   ```

## Development Guidelines

### Coding Standards

- Follow PSR-12 coding standards for PHP
- Use Laravel best practices
- Write descriptive variable and function names
- Add comments for complex logic
- Keep functions small and focused

### Database Migrations

- Always create reversible migrations
- Use descriptive migration names
- Test both `up()` and `down()` methods
- Never modify existing migrations that have been committed

### Commit Messages

Follow conventional commits format:

```
type(scope): subject

body (optional)

footer (optional)
```

**Types:**
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes (formatting)
- `refactor`: Code refactoring
- `test`: Adding or updating tests
- `chore`: Maintenance tasks

**Examples:**
```
feat(auth): add multi-language support to login page
fix(orders): resolve order status update issue
docs(readme): update installation instructions
```

### Branch Naming

- `feature/` - New features
- `fix/` - Bug fixes
- `docs/` - Documentation updates
- `refactor/` - Code refactoring
- `test/` - Test additions/updates

Examples:
- `feature/seller-dashboard`
- `fix/payment-gateway-error`
- `docs/api-documentation`

## Pull Request Process

1. **Update Documentation**: Ensure README.md and relevant docs are updated

2. **Test Your Changes**: 
   - Run existing tests: `php artisan test`
   - Add new tests for new features
   - Manually test the feature

3. **Update CHANGELOG**: Add your changes to the unreleased section

4. **Create Pull Request**:
   - Use a descriptive title
   - Reference related issues
   - Provide detailed description of changes
   - Include screenshots for UI changes

5. **Code Review**: Address feedback from reviewers

6. **Merge**: Once approved, your PR will be merged

## Testing

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/Auth/LoginTest.php

# Run with coverage
php artisan test --coverage
```

### Writing Tests

- Write tests for all new features
- Maintain test coverage above 80%
- Use descriptive test names
- Follow AAA pattern (Arrange, Act, Assert)

Example:
```php
public function test_seller_can_create_product_within_plan_limit()
{
    // Arrange
    $seller = User::factory()->create();
    $seller->assignRole('seller');
    
    // Act
    $response = $this->actingAs($seller)->post('/products', [
        'name' => 'Test Product',
        'price' => 99.99,
    ]);
    
    // Assert
    $response->assertStatus(201);
    $this->assertDatabaseHas('products', ['name' => 'Test Product']);
}
```

## Project Structure

```
kedai/
├── app/
│   ├── Http/Controllers/  # Controllers
│   ├── Models/            # Eloquent models
│   ├── Services/          # Business logic
│   └── Helpers/           # Helper functions
├── database/
│   ├── migrations/        # Database migrations
│   └── seeders/           # Data seeders
├── Documentation/         # Project documentation
├── resources/
│   ├── views/            # Blade templates
│   ├── js/               # JavaScript/Vue
│   └── css/              # Stylesheets
└── tests/
    ├── Feature/          # Feature tests
    └── Unit/             # Unit tests
```

## Areas for Contribution

### High Priority
- [ ] Dynamic theming system
- [ ] Multi-language translation files
- [ ] Math captcha implementation
- [ ] Super Admin dashboard UI
- [ ] Seller registration flow

### Medium Priority
- [ ] Payment gateway integrations
- [ ] Landing page builder
- [ ] Email templates
- [ ] Analytics dashboards

### Low Priority
- [ ] UI/UX improvements
- [ ] Performance optimizations
- [ ] Additional tests
- [ ] Documentation improvements

## Questions?

- Check the [Documentation](Documentation/) folder
- Review the [PRD](Documentation/PRD.md)
- Open an issue for discussion

## License

By contributing, you agree that your contributions will be licensed under the same license as the project.

---

Thank you for contributing to Kedai! 🎉
