# Universal Coding Standards (Improved Version)

## 1. Core Principles (Mandatory)
- SOLID Principles
- DRY (Don't Repeat Yourself)
- KISS (Keep It Simple, Stupid)
- YAGNI (You Aren’t Gonna Need It)
- Clean Code (Robert C. Martin)
- Single Responsibility for every function/class
- Max function parameters: **3**
- No Boolean parameters (no function(x, true))
- No Magic Numbers or Strings → use Constants / Enums
- All names must be **clear, explicit, descriptive**
- Variables, functions, classes in English only
- camelCase for variables and methods, PascalCase for classes
- `declare(strict_types=1);` in every PHP file

---

## 2. General Project Architecture (Framework-Agnostic)
These rules work for **any project** (Laravel, Node.js, Python, Go, Java…).

### 2.1 Folder Structure Principles
- Domain logic must be separated from framework-specific code.
- No business logic inside controllers, routes, views, or handlers.
- Use a layered architecture:
  - **Domain** → core logic
  - **Application/Services** → use cases
  - **Infrastructure** → DB, external APIs
  - **Presentation** → controllers, routes, CLI, UI

### 2.2 Services Layer Rules
- Every use case has its own Service or Action class.
- Service = one responsibility only.
- All operations that modify state must be inside services.
- Transactions should only exist in services (not controllers).

---

## 3. Repositories & Data Access
- No direct database queries in controllers or services.
- Every model/entity must have its Repository + Interface.
- Repository = for read/write logic only.
- Use Scopes or Query Helpers for repeated queries.

---

## 4. DTO (Data Transfer Objects)
- No arrays for input/output.
- Use DTOs for:
  - Request input
  - Service input
  - Service output
- DTOs must be immutable.
- Avoid passing Request objects into services.

---

## 5. Exceptions & Error Handling
- No generic exceptions.
- Use custom exceptions for all domain/application errors.
- Exception Handler must convert exceptions to unified responses.
- Never return raw messages → use standardized error codes.

---

## 6. API Responses (Any Framework)
- All API responses must pass through a Response/Resource layer.
- Unified JSON structure:
```
{
    "success": true,
    "data": {},
    "message": "optional"
}
```
- No direct return of arrays or models.

---

## 7. Logging & Auditing
- No logging inside controllers.
- All logs are handled inside:
  - Events
  - Listeners
  - Domain services
- No print_r, dump, die, var_dump in production code.

---

## 8. Events & Listeners (Framework Neutral)
- Use Events for:
  - Notifications
  - Logging
  - Side effects
- Business logic must NOT exist in listeners.
- Services trigger events only.

---

## 9. Testing Standards
- Unit tests for domain logic.
- Integration tests for services.
- Feature tests for endpoints/UI.
- Avoid mocking too much; mock external services only.

---

## 10. What Is Forbidden (Always)
- Fat controllers
- God classes
- Anemic domain models
- Passing arrays everywhere
- $data, $obj, $arr, $x variable names
- Storing logic inside model properties
- Copy-paste logic
- Static classes for business logic
- Global state
- Hard-coded numbers/strings

---

## 11. Examples of Valid Commands for AI
- "Create UserService with DTO + Repository"
- "Generate ProductRepositoryInterface"
- "Create CreateOrderAction with validation rules"
- "Make OrderDTO with strict types"

Any request outside this architecture must be rejected automatically.

