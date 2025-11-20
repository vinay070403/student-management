# File Tree: student-management-second

Generated on: 10/11/2025, 7:22:27 PM
Root path: `c:\xampp\htdocs\student-management-second`

```
├── 📁 .git/ 🚫 (auto-hidden)
├── 📁 app/
│   ├── 📁 Http/
│   │   ├── 📁 Controllers/
│   │   │   ├── 🐘 AdminController.php
│   │   │   ├── 🐘 AuthController.php
│   │   │   ├── 🐘 ClassController.php
│   │   │   ├── 🐘 Controller.php
│   │   │   ├── 🐘 CountryController.php
│   │   │   ├── 🐘 ProfileController.php
│   │   │   ├── 🐘 SchoolController.php
│   │   │   ├── 🐘 StateController.php
│   │   │   ├── 🐘 StudentController.php
│   │   │   └── 🐘 SubjectController.php
│   │   ├── 📁 Middleware/
│   │   │   └── 🐘 RedirectIfAuthenticated.php
│   │   └── 📁 Requests/
│   │       ├── 📁 Admin/
│   │       │   ├── 🐘 BulkDeleteUserRequest.php
│   │       │   ├── 🐘 StoreUserRequest.php
│   │       │   └── 🐘 UpdateUserRequest.php
│   │       ├── 📁 Auth/
│   │       │   ├── 🐘 ForgotPasswordRequest.php
│   │       │   ├── 🐘 LoginRequest.php
│   │       │   └── 🐘 ResetPasswordRequest.php
│   │       └── 📁 Class/
│   │           ├── 🐘 StoreClassRequest.php
│   │           └── 🐘 UpdateClassRequest.php
│   ├── 📁 Models/
│   │   ├── 🐘 SchoolClass.php
│   │   ├── 🐘 Country.php
│   │   ├── 🐘 GradeScale.php
│   │   ├── 🐘 PermissionGroup.php
│   │   ├── 🐘 School.php
│   │   ├── 🐘 State.php
│   │   ├── 🐘 StudentGrade.php
│   │   ├── 🐘 Subject.php
│   │   └── 🐘 User.php
│   └── 📁 Providers/
│       └── 🐘 AppServiceProvider.php
├── 📁 bootstrap/
│   ├── 📁 cache/ 🚫 (auto-hidden)
│   ├── 🐘 app.php
│   └── 🐘 providers.php
├── 📁 config/
│   ├── 🐘 app.php
│   ├── 🐘 auth.php
│   ├── 🐘 cache.php
│   ├── 🐘 database.php
│   ├── 🐘 filesystems.php
│   ├── 🐘 logging.php
│   ├── 🐘 mail.php
│   ├── 🐘 permission.php
│   ├── 🐘 queue.php
│   ├── 🐘 services.php
│   └── 🐘 session.php
├── 📁 database/
│   ├── 📁 factories/
│   │   └── 🐘 UserFactory.php
│   ├── 📁 migrations/
│   │   ├── 🐘 0001_01_01_000000_create_users_table.php
│   │   ├── 🐘 0001_01_01_000001_create_cache_table.php
│   │   ├── 🐘 0001_01_01_000002_create_jobs_table.php
│   │   └── 🐘 2025_09_22_102848_create_permission_tables.php
│   ├── 📁 seeders/
│   │   ├── 🐘 DatabaseSeeder.php
│   │   └── 🐘 RolePermissionSeeder.php
│   ├── 🚫 .gitignore
│   └── 🗄️ database.sqlite
├── 📁 public/
│   ├── 📁 assets/
│   │   ├── 📁 css/
│   │   │   ├── 📁 maps/
│   │   │   │   └── 📄 style.css.map 🚫 (auto-hidden)
│   │   │   └── 🎨 style.css
│   │   ├── 📁 fonts/
│   │   │   ├── 📁 Manrope/
│   │   │   │   ├── 📄 Manrope-Bold.eot
│   │   │   │   ├── 📄 Manrope-Bold.ttf
│   │   │   │   ├── 📄 Manrope-Bold.woff
│   │   │   │   ├── 📄 Manrope-Bold.woff2
│   │   │   │   ├── 📄 Manrope-ExtraBold.eot
│   │   │   │   ├── 📄 Manrope-ExtraBold.ttf
│   │   │   │   ├── 📄 Manrope-ExtraBold.woff
│   │   │   │   ├── 📄 Manrope-ExtraBold.woff2
│   │   │   │   ├── 📄 Manrope-ExtraLight.eot
│   │   │   │   ├── 📄 Manrope-ExtraLight.ttf
│   │   │   │   ├── 📄 Manrope-ExtraLight.woff
│   │   │   │   ├── 📄 Manrope-ExtraLight.woff2
│   │   │   │   ├── 📄 Manrope-Light.eot
│   │   │   │   ├── 📄 Manrope-Light.ttf
│   │   │   │   ├── 📄 Manrope-Light.woff
│   │   │   │   ├── 📄 Manrope-Light.woff2
│   │   │   │   ├── 📄 Manrope-Medium.eot
│   │   │   │   ├── 📄 Manrope-Medium.ttf
│   │   │   │   ├── 📄 Manrope-Medium.woff
│   │   │   │   ├── 📄 Manrope-Medium.woff2
│   │   │   │   ├── 📄 Manrope-Regular.eot
│   │   │   │   ├── 📄 Manrope-Regular.ttf
│   │   │   │   ├── 📄 Manrope-Regular.woff
│   │   │   │   ├── 📄 Manrope-Regular.woff2
│   │   │   │   ├── 📄 Manrope-SemiBold.eot
│   │   │   │   ├── 📄 Manrope-SemiBold.ttf
│   │   │   │   ├── 📄 Manrope-SemiBold.woff
│   │   │   │   └── 📄 Manrope-SemiBold.woff2
│   │   │   ├── 📁 Nunito/
│   │   │   │   ├── 📄 Nunito-Black.eot
│   │   │   │   ├── 📄 Nunito-Black.ttf
│   │   │   │   ├── 📄 Nunito-Black.woff
│   │   │   │   ├── 📄 Nunito-Black.woff2
│   │   │   │   ├── 📄 Nunito-Bold.eot
│   │   │   │   ├── 📄 Nunito-Bold.ttf
│   │   │   │   ├── 📄 Nunito-Bold.woff
│   │   │   │   ├── 📄 Nunito-Bold.woff2
│   │   │   │   ├── 📄 Nunito-ExtraBold.eot
│   │   │   │   ├── 📄 Nunito-ExtraBold.ttf
│   │   │   │   ├── 📄 Nunito-ExtraBold.woff
│   │   │   │   ├── 📄 Nunito-ExtraBold.woff2
│   │   │   │   ├── 📄 Nunito-ExtraLight.eot
│   │   │   │   ├── 📄 Nunito-ExtraLight.ttf
│   │   │   │   ├── 📄 Nunito-ExtraLight.woff
│   │   │   │   ├── 📄 Nunito-ExtraLight.woff2
│   │   │   │   ├── 📄 Nunito-Italic.eot
│   │   │   │   ├── 📄 Nunito-Italic.ttf
│   │   │   │   ├── 📄 Nunito-Italic.woff
│   │   │   │   ├── 📄 Nunito-Italic.woff2
│   │   │   │   ├── 📄 Nunito-Light.eot
│   │   │   │   ├── 📄 Nunito-Light.ttf
│   │   │   │   ├── 📄 Nunito-Light.woff
│   │   │   │   ├── 📄 Nunito-Light.woff2
│   │   │   │   ├── 📄 Nunito-Regular.eot
│   │   │   │   ├── 📄 Nunito-Regular.ttf
│   │   │   │   ├── 📄 Nunito-Regular.woff
│   │   │   │   ├── 📄 Nunito-Regular.woff2
│   │   │   │   ├── 📄 Nunito-SemiBold.eot
│   │   │   │   ├── 📄 Nunito-SemiBold.ttf
│   │   │   │   ├── 📄 Nunito-SemiBold.woff
│   │   │   │   └── 📄 Nunito-SemiBold.woff2
│   │   │   └── 📁 Roboto/
│   │   │       ├── 📄 Roboto-Black.eot
│   │   │       ├── 📄 Roboto-Black.ttf
│   │   │       ├── 📄 Roboto-Black.woff
│   │   │       ├── 📄 Roboto-Black.woff2
│   │   │       ├── 📄 Roboto-Bold.eot
│   │   │       ├── 📄 Roboto-Bold.ttf
│   │   │       ├── 📄 Roboto-Bold.woff
│   │   │       ├── 📄 Roboto-Bold.woff2
│   │   │       ├── 📄 Roboto-Light.eot
│   │   │       ├── 📄 Roboto-Light.ttf
│   │   │       ├── 📄 Roboto-Light.woff
│   │   │       ├── 📄 Roboto-Light.woff2
│   │   │       ├── 📄 Roboto-Medium.eot
│   │   │       ├── 📄 Roboto-Medium.ttf
│   │   │       ├── 📄 Roboto-Medium.woff
│   │   │       ├── 📄 Roboto-Medium.woff2
│   │   │       ├── 📄 Roboto-Regular.eot
│   │   │       ├── 📄 Roboto-Regular.ttf
│   │   │       ├── 📄 Roboto-Regular.woff
│   │   │       └── 📄 Roboto-Regular.woff2
│   │   ├── 📁 images/
│   │   │   ├── 📁 auth/
│   │   │   │   ├── 🖼️ lockscreen-bg.jpg
│   │   │   │   ├── 🖼️ login-bg.jpg
│   │   │   │   └── 🖼️ register-bg.jpg
│   │   │   ├── 📁 carousel/
│   │   │   │   ├── 🖼️ banner_1.jpg
│   │   │   │   ├── 🖼️ banner_10.jpg
│   │   │   │   ├── 🖼️ banner_11.jpg
│   │   │   │   ├── 🖼️ banner_12.jpg
│   │   │   │   ├── 🖼️ banner_2.jpg
│   │   │   │   ├── 🖼️ banner_3.jpg
│   │   │   │   ├── 🖼️ banner_4.jpg
│   │   │   │   ├── 🖼️ banner_5.jpg
│   │   │   │   ├── 🖼️ banner_6.jpg
│   │   │   │   ├── 🖼️ banner_7.jpg
│   │   │   │   ├── 🖼️ banner_8.jpg
│   │   │   │   └── 🖼️ banner_9.jpg
│   │   │   ├── 📁 dashboard/
│   │   │   │   ├── 🖼️ people.png
│   │   │   │   ├── 🖼️ people.svg
│   │   │   │   ├── 🖼️ people11.svg
│   │   │   │   ├── 🖼️ shape-1.svg
│   │   │   │   ├── 🖼️ shape-2.svg
│   │   │   │   ├── 🖼️ shape-3.svg
│   │   │   │   └── 🖼️ shape-4.svg
│   │   │   ├── 📁 demo/
│   │   │   │   ├── 🖼️ boxed-layout.jpg
│   │   │   │   ├── 🖼️ calendar.jpg
│   │   │   │   ├── 🖼️ compact-menu.jpg
│   │   │   │   ├── 🖼️ dark-sidebar.jpg
│   │   │   │   ├── 🖼️ email.jpg
│   │   │   │   ├── 🖼️ fixed-menu.jpg
│   │   │   │   ├── 🖼️ horizontal-menu-dark.jpg
│   │   │   │   ├── 🖼️ horizontal-menu-light.jpg
│   │   │   │   ├── 🖼️ icon-menu.jpg
│   │   │   │   ├── 🖼️ login.jpg
│   │   │   │   ├── 🖼️ portfolio.jpg
│   │   │   │   ├── 🖼️ pricing.jpg
│   │   │   │   ├── 🖼️ toggle-menu.jpg
│   │   │   │   ├── 🖼️ toggle-overlay-menu.jpg
│   │   │   │   ├── 🖼️ vertical-dark.jpg
│   │   │   │   └── 🖼️ vertical-default.jpg
│   │   │   ├── 📁 faces/
│   │   │   │   ├── 🖼️ face1.jpg
│   │   │   │   ├── 🖼️ face10.jpg
│   │   │   │   ├── 🖼️ face11.jpg
│   │   │   │   ├── 🖼️ face12.jpg
│   │   │   │   ├── 🖼️ face13.jpg
│   │   │   │   ├── 🖼️ face14.jpg
│   │   │   │   ├── 🖼️ face15.jpg
│   │   │   │   ├── 🖼️ face16.jpg
│   │   │   │   ├── 🖼️ face17.jpg
│   │   │   │   ├── 🖼️ face18.jpg
│   │   │   │   ├── 🖼️ face19.jpg
│   │   │   │   ├── 🖼️ face2.jpg
│   │   │   │   ├── 🖼️ face20.jpg
│   │   │   │   ├── 🖼️ face21.jpg
│   │   │   │   ├── 🖼️ face22.jpg
│   │   │   │   ├── 🖼️ face23.jpg
│   │   │   │   ├── 🖼️ face24.jpg
│   │   │   │   ├── 🖼️ face25.jpg
│   │   │   │   ├── 🖼️ face26.jpg
│   │   │   │   ├── 🖼️ face27.jpg
│   │   │   │   ├── 🖼️ face28.jpg
│   │   │   │   ├── 🖼️ face3.jpg
│   │   │   │   ├── 🖼️ face4.jpg
│   │   │   │   ├── 🖼️ face5.jpg
│   │   │   │   ├── 🖼️ face6.jpg
│   │   │   │   ├── 🖼️ face7.jpg
│   │   │   │   ├── 🖼️ face8.jpg
│   │   │   │   └── 🖼️ face9.jpg
│   │   │   ├── 📁 file-icons/
│   │   │   │   ├── 📁 128/
│   │   │   │   │   ├── 🖼️ 001-interface-1.png
│   │   │   │   │   ├── 🖼️ 002-tool.png
│   │   │   │   │   ├── 🖼️ 003-interface.png
│   │   │   │   │   ├── 🖼️ 004-folder-1.png
│   │   │   │   │   ├── 🖼️ 005-database.png
│   │   │   │   │   ├── 🖼️ 006-record.png
│   │   │   │   │   ├── 🖼️ 007-folder.png
│   │   │   │   │   └── 🖼️ 008-archive.png
│   │   │   │   ├── 📁 256/
│   │   │   │   │   ├── 🖼️ 001-interface-1.png
│   │   │   │   │   ├── 🖼️ 002-tool.png
│   │   │   │   │   ├── 🖼️ 003-interface.png
│   │   │   │   │   ├── 🖼️ 004-folder-1.png
│   │   │   │   │   ├── 🖼️ 005-database.png
│   │   │   │   │   ├── 🖼️ 006-record.png
│   │   │   │   │   ├── 🖼️ 007-folder.png
│   │   │   │   │   └── 🖼️ 008-archive.png
│   │   │   │   ├── 📁 512/
│   │   │   │   │   ├── 🖼️ 001-interface-1.png
│   │   │   │   │   ├── 🖼️ 002-tool.png
│   │   │   │   │   ├── 🖼️ 003-interface.png
│   │   │   │   │   ├── 🖼️ 004-folder-1.png
│   │   │   │   │   ├── 🖼️ 005-database.png
│   │   │   │   │   ├── 🖼️ 006-record.png
│   │   │   │   │   ├── 🖼️ 007-folder.png
│   │   │   │   │   └── 🖼️ 008-archive.png
│   │   │   │   ├── 📁 64/
│   │   │   │   │   ├── 🖼️ 001-interface-1.png
│   │   │   │   │   ├── 🖼️ 002-tool.png
│   │   │   │   │   ├── 🖼️ 003-interface.png
│   │   │   │   │   ├── 🖼️ 004-folder-1.png
│   │   │   │   │   ├── 🖼️ 005-database.png
│   │   │   │   │   ├── 🖼️ 006-record.png
│   │   │   │   │   ├── 🖼️ 007-folder.png
│   │   │   │   │   └── 🖼️ 008-archive.png
│   │   │   │   └── 🖼️ flag.png
│   │   │   ├── 📁 lightbox/
│   │   │   │   ├── 🖼️ play-button.png
│   │   │   │   ├── 🖼️ thumb-v-v-1.jpg
│   │   │   │   ├── 🖼️ thumb-v-v-2.jpg
│   │   │   │   ├── 🖼️ thumb-v-y-1.jpg
│   │   │   │   └── 🖼️ thumb-v-y-2.jpg
│   │   │   ├── 📁 samples/
│   │   │   │   ├── 📁 1280x768/
│   │   │   │   │   ├── 🖼️ 1.jpg
│   │   │   │   │   ├── 🖼️ 10.jpg
│   │   │   │   │   ├── 🖼️ 11.jpg
│   │   │   │   │   ├── 🖼️ 12.jpg
│   │   │   │   │   ├── 🖼️ 13.jpg
│   │   │   │   │   ├── 🖼️ 14.jpg
│   │   │   │   │   ├── 🖼️ 15.jpg
│   │   │   │   │   ├── 🖼️ 2.jpg
│   │   │   │   │   ├── 🖼️ 3.jpg
│   │   │   │   │   ├── 🖼️ 4.jpg
│   │   │   │   │   ├── 🖼️ 5.jpg
│   │   │   │   │   ├── 🖼️ 6.jpg
│   │   │   │   │   ├── 🖼️ 7.jpg
│   │   │   │   │   ├── 🖼️ 8.jpg
│   │   │   │   │   └── 🖼️ 9.jpg
│   │   │   │   └── 📁 300x300/
│   │   │   │       ├── 🖼️ 1.jpg
│   │   │   │       ├── 🖼️ 10.jpg
│   │   │   │       ├── 🖼️ 11.jpg
│   │   │   │       ├── 🖼️ 12.jpg
│   │   │   │       ├── 🖼️ 13.jpg
│   │   │   │       ├── 🖼️ 14.jpg
│   │   │   │       ├── 🖼️ 15.jpg
│   │   │   │       ├── 🖼️ 2.jpg
│   │   │   │       ├── 🖼️ 3.jpg
│   │   │   │       ├── 🖼️ 4.jpg
│   │   │   │       ├── 🖼️ 5.jpg
│   │   │   │       ├── 🖼️ 6.jpg
│   │   │   │       ├── 🖼️ 7.jpg
│   │   │   │       ├── 🖼️ 8.jpg
│   │   │   │       └── 🖼️ 9.jpg
│   │   │   ├── 📁 sprites/
│   │   │   │   ├── 🖼️ blue.png
│   │   │   │   ├── 🖼️ dark.png
│   │   │   │   ├── 🖼️ flag.png
│   │   │   │   ├── 🖼️ green.png
│   │   │   │   ├── 🖼️ jsgrid-icons.png
│   │   │   │   ├── 🖼️ red.png
│   │   │   │   └── 🖼️ yellow.png
│   │   │   ├── 🖼️ bg.jpg
│   │   │   ├── 🖼️ default-avatar.png
│   │   │   ├── 🖼️ download (1) (1).svg
│   │   │   ├── 🖼️ favicon.ico
│   │   │   ├── 🖼️ favicon.png
│   │   │   ├── 🖼️ logo-light.svg
│   │   │   ├── 🖼️ logo-mini.svg
│   │   │   ├── 🖼️ logo-white.svg
│   │   │   ├── 🖼️ logo.svg
│   │   │   ├── 🖼️ logo1.svg
│   │   │   └── 🖼️ logo12.svg
│   │   ├── 📁 js/
│   │   │   ├── 📄 chart.js
│   │   │   ├── 📄 codemirror.js
│   │   │   ├── 📄 dashboard-dark.js
│   │   │   ├── 📄 dashboard.js
│   │   │   ├── 📄 data-table.js
│   │   │   ├── 📄 data.txt
│   │   │   ├── 📄 dataTables.select.min.js 🚫 (auto-hidden)
│   │   │   ├── 📄 demo.js
│   │   │   ├── 📄 file-upload.js
│   │   │   ├── 📄 jquery-file-upload.js
│   │   │   ├── 📄 jquery.cookie.js
│   │   │   ├── 📄 off-canvas.js
│   │   │   ├── 🎨 select.dataTables.min.css 🚫 (auto-hidden)
│   │   │   ├── 📄 select2.js
│   │   │   ├── 📄 settings.js
│   │   │   ├── 📄 template.js
│   │   │   ├── 📄 todolist.js
│   │   │   └── 📄 typeahead.js
│   │   ├── 📁 scss/
│   │   │   ├── 📁 common/
│   │   │   │   └── 📁 light/
│   │   │   │       ├── 📁 components/
│   │   │   │       │   ├── 📁 plugin-overrides/
│   │   │   │       │   │   ├── 🎨 _codemirror.scss
│   │   │   │       │   │   ├── 🎨 _data-tables.scss
│   │   │   │       │   │   ├── 🎨 _pws-tabs.scss
│   │   │   │       │   │   ├── 🎨 _select2.scss
│   │   │   │       │   │   └── 🎨 _typeahead.scss
│   │   │   │       │   ├── 🎨 _badges.scss
│   │   │   │       │   ├── 🎨 _buttons.scss
│   │   │   │       │   ├── 🎨 _cards.scss
│   │   │   │       │   ├── 🎨 _checkbox-radio.scss
│   │   │   │       │   ├── 🎨 _dropdown.scss
│   │   │   │       │   ├── 🎨 _forms.scss
│   │   │   │       │   ├── 🎨 _icons.scss
│   │   │   │       │   ├── 🎨 _lists.scss
│   │   │   │       │   ├── 🎨 _preview.scss
│   │   │   │       │   ├── 🎨 _tables.scss
│   │   │   │       │   └── 🎨 _todo-list.scss
│   │   │   │       ├── 📁 landing-screens/
│   │   │   │       │   └── 🎨 _auth.scss
│   │   │   │       ├── 📁 mixins/
│   │   │   │       │   ├── 🎨 _animation.scss
│   │   │   │       │   ├── 🎨 _badges.scss
│   │   │   │       │   ├── 🎨 _blockqoute.scss
│   │   │   │       │   ├── 🎨 _breadcrumbs.scss
│   │   │   │       │   ├── 🎨 _buttons.scss
│   │   │   │       │   ├── 🎨 _cards.scss
│   │   │   │       │   ├── 🎨 _misc.scss
│   │   │   │       │   ├── 🎨 _no-ui-slider.scss
│   │   │   │       │   ├── 🎨 _pagination.scss
│   │   │   │       │   ├── 🎨 _popovers.scss
│   │   │   │       │   └── 🎨 _tooltips.scss
│   │   │   │       ├── 🎨 _background.scss
│   │   │   │       ├── 🎨 _dashboard.scss
│   │   │   │       ├── 🎨 _demo.scss
│   │   │   │       ├── 🎨 _fonts.scss
│   │   │   │       ├── 🎨 _footer.scss
│   │   │   │       ├── 🎨 _functions.scss
│   │   │   │       ├── 🎨 _misc.scss
│   │   │   │       ├── 🎨 _reset.scss
│   │   │   │       ├── 🎨 _typography.scss
│   │   │   │       ├── 🎨 _utilities.scss
│   │   │   │       ├── 🎨 _variables.scss
│   │   │   │       └── 🎨 common.scss
│   │   │   ├── 📁 fonts/
│   │   │   │   └── 📁 Manrope/
│   │   │   │       └── 📄 Manrope-Light.eot
│   │   │   ├── 🎨 _layouts.scss
│   │   │   ├── 🎨 _navbar.scss
│   │   │   ├── 🎨 _settings-panel.scss
│   │   │   ├── 🎨 _sidebar.scss
│   │   │   ├── 🎨 _variables.scss
│   │   │   ├── 🎨 _vertical-wrapper.scss
│   │   │   └── 🎨 style.scss
│   │   └── 📁 vendors/ 🚫 (auto-hidden)
│   ├── 📄 .htaccess
│   ├── 🖼️ favicon.ico
│   ├── 🐘 index.php
│   ├── 📄 robots.txt
│   └── 📄 storage 🚫 (auto-hidden)
├── 📁 resources/
│   ├── 📁 css/
│   │   └── 🎨 app.css
│   ├── 📁 js/
│   │   ├── 📄 app.js
│   │   └── 📄 bootstrap.js
│   └── 📁 views/
│       ├── 📁 admin/
│       │   ├── 📁 countries/
│       │   │   ├── 🐘 create.blade.php
│       │   │   ├── 🐘 edit.blade.php
│       │   │   └── 🐘 index.blade.php
│       │   ├── 📁 profile/
│       │   │   └── 🐘 edit.blade.php
│       │   ├── 📁 schools/
│       │   │   ├── 📁 classes/
│       │   │   │   ├── 🐘 create.blade.php
│       │   │   │   ├── 🐘 edit.blade.php
│       │   │   │   └── 🐘 index.blade.php
│       │   │   ├── 📁 subjects/
│       │   │   │   ├── 🐘 create.blade.php
│       │   │   │   ├── 🐘 edit.blade.php
│       │   │   │   └── 🐘 index.blade.php
│       │   │   ├── 🐘 create.blade.php
│       │   │   ├── 🐘 edit.blade.php
│       │   │   └── 🐘 index.blade.php
│       │   ├── 📁 states/
│       │   │   ├── 🐘 create.blade.php
│       │   │   ├── 🐘 edit.blade.php
│       │   │   └── 🐘 index.blade.php
│       │   ├── 📁 students/
│       │   │   ├── 🐘 create.blade.php
│       │   │   ├── 🐘 edit.blade.php
│       │   │   └── 🐘 index.blade.php
│       │   ├── 📁 users/
│       │   │   ├── 📄 add
│       │   │   ├── 🐘 create.blade.php
│       │   │   ├── 🐘 edit.blade.php
│       │   │   ├── 🐘 index.blade.php
│       │   │   └── 📄 old add
│       │   ├── 🐘 dashboard.blade.php
│       │   └── 📄 old
│       ├── 📁 auth/
│       │   ├── 🐘 forgot-password.blade.php
│       │   ├── 🐘 login.blade.php
│       │   └── 🐘 reset-password.blade.php
│       ├── 📁 layouts/
│       │   ├── 📁 partials/
│       │   │   ├── 🐘 footer.blade.php
│       │   │   ├── 🐘 header.blade.php
│       │   │   └── 🐘 sidebar.blade.php
│       │   └── 🐘 app.blade.php
│       └── 🐘 welcome.blade.php
├── 📁 routes/
│   ├── 🐘 console.php
│   └── 🐘 web.php
├── 📁 storage/
│   ├── 📁 app/
│   │   ├── 📁 private/
│   │   │   └── 🚫 .gitignore
│   │   ├── 📁 public/
│   │   │   ├── 📁 avatars/
│   │   │   │   ├── 🖼️ 0Ep7xzDzPSxmoxGrWka39zybgmEboagPe9pyCfLB.png
│   │   │   │   ├── 🖼️ 6JBUna34mR4srPpA9L7WDnV1UvRfk4D7gbvnMmeh.jpg
│   │   │   │   ├── 🖼️ EntjKKWzVRkZLYzawuDRXhs63XeBR0Wt0GwsDzVa.png
│   │   │   │   ├── 🖼️ H09lWUH6kFqvwUE30Psj1X9rmvvzdDcLJl5t5fvq.png
│   │   │   │   ├── 🖼️ KXwwxb5SNRsJlBJBhxj1wPcRv0wS6RYu15ylNsqo.png
│   │   │   │   ├── 🖼️ LCL7N2JuuN36tplx2g2Bgj8VaI3oCd3pYehpUVFA.png
│   │   │   │   ├── 🖼️ OL6EunP74hAMfe7xaGEjOBOTO8WZb7Qqmjlb4CSm.png
│   │   │   │   ├── 🖼️ U26oml00A4FjPTqIdfPxywZQpFTeLcRM3zMmnwbB.png
│   │   │   │   ├── 🖼️ Vy9IF5BNSxN8ShMCHlCsBwbGASche5xpq10GPnDN.png
│   │   │   │   ├── 🖼️ XrWXCjBwXrNop6PRmToY9SEIWlwSSkEQXI6nvrwR.png
│   │   │   │   ├── 🖼️ ZKGMvlV0ky2GnJKD719FjJB0oDTwXKFvzPlyS17J.png
│   │   │   │   ├── 🖼️ a82ASB1AMgddjw8DmHmTt24aZ7TX7FRn5OTdnz80.png
│   │   │   │   ├── 🖼️ iTQs5WzZd3ZXj1YQfWkYxNhW8mdupPMcp1Efdz7L.png
│   │   │   │   ├── 🖼️ kDZ7ODfsgtADQcjginnYcO14pt4OGQVwmlS4yOIt.png
│   │   │   │   ├── 🖼️ wcARunOyOLE87XtTvaFUbSbUJUxMOWJPGOxOgk20.png
│   │   │   │   ├── 🖼️ xgTHfc59o2hMhSUMEP3NEDbAWZUpE2yAkuy4qYaY.png
│   │   │   │   ├── 🖼️ y47Z3uxU56fQVzNQcFvUiRbpXvLgomf5quoizjxp.png
│   │   │   │   └── 🖼️ yy5JkZEkgTTkBiRciTMZqnxRhqoN8nPDC6QsXtmp.png
│   │   │   └── 🚫 .gitignore
│   │   └── 🚫 .gitignore
│   ├── 📁 framework/
│   │   ├── 📁 cache/ 🚫 (auto-hidden)
│   │   ├── 📁 sessions/
│   │   │   └── 🚫 .gitignore
│   │   ├── 📁 testing/
│   │   │   └── 🚫 .gitignore
│   │   ├── 📁 views/
│   │   │   ├── 🚫 .gitignore
│   │   │   ├── 🐘 0d1f33b9e9aff27e8508d92574c4ec7e.php
│   │   │   ├── 🐘 1b08b4ffb9247ac66078b1a7f12ebd1c.php
│   │   │   ├── 🐘 1ebfafbc70dfbef088cdb0eacf09f843.php
│   │   │   ├── 🐘 2fee4c38daac6cf9246b0c8d96419cef.php
│   │   │   ├── 🐘 37c7e40577685090e832e0f7ad3d8e0e.php
│   │   │   ├── 🐘 469433722f7b312454d02b9539035e1e.php
│   │   │   ├── 🐘 4db69595b098b83f06a6934321382085.php
│   │   │   ├── 🐘 6f80b96497bf5a2e668d78b4bc542b7d.php
│   │   │   ├── 🐘 7e545337230d286288105e22852810d3.php
│   │   │   ├── 🐘 89db583eed59c5a4a1ae12885e6c6e38.php
│   │   │   ├── 🐘 8affa26a85c30d44419e22b9f6fb1bcd.php
│   │   │   ├── 🐘 8bb6117e6edd478d72499a8435274d1e.php
│   │   │   ├── 🐘 8c8e44ac99ddfc63cdd40c631e68716d.php
│   │   │   ├── 🐘 abee72aa5dfb0dda4e18263788e5d0cb.php
│   │   │   └── 🐘 e3d5e4e5d66093c6b880140539754f0c.php
│   │   └── 🚫 .gitignore
│   └── 📁 logs/
│       ├── 🚫 .gitignore
│       └── 📋 laravel.log 🚫 (auto-hidden)
├── 📁 tests/
│   ├── 📁 Feature/
│   │   └── 🐘 ExampleTest.php
│   ├── 📁 Unit/
│   │   └── 🐘 ExampleTest.php
│   └── 🐘 TestCase.php
├── 📁 vendor/ 🚫 (auto-hidden)
├── 📄 .editorconfig
├── 🔒 .env 🚫 (auto-hidden)
├── 📄 .env.example
├── 📄 .gitattributes
├── 🚫 .gitignore
├── 📖 README.md
├── 📄 artisan
├── 📄 composer.json
├── 🔒 composer.lock 🚫 (auto-hidden)
├── 📄 package.json
├── 📄 phpunit.xml
└── 📄 vite.config.js
```

---

_Generated by FileTree Pro Extension_
