## Link Path Spec

### Scope
Template HTML files under `templates/`.

### Requirement
When pages are served from a project subdirectory (for example `/Templates2/templates/...`), local static resource links must not assume web root (`/`).

### Rules
1. CSS links should use relative paths from `templates/` to `styles/` (for example `../styles/style.css`).
2. Asset image links should use relative paths from `templates/` to `assets/` (for example `../assets/favicon.svg`).
3. JavaScript links should use relative paths from `templates/` to `scripts/` (for example `../scripts/main.js`).

