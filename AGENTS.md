# AGENTS.md — Teh Dandang Development Guidelines

## Design Discipline: Hallmark Active & Anti-Vibe-Coding Rules
This project follows strict production standards located in:
- Skill instructions: `.agents/skills/hallmark/SKILL.md` and `references/`
- Cursor rules: `.cursor/rules/hallmark.mdc`
- Locked system: `design.md`
- Token source: `public/css/tokens.css`

### Core Rules for UI & Code Generation:
1. **Font**: Use **Poppins** as the primary font family for display, headings, and body. Use **JetBrains Mono** for numerical telemetry and tabular data (`tabular-nums`). Never use browser default serif/sans-serif.
2. **Icons**: Use **Material Design Icons (MDI)** (`<i class="mdi mdi-..."></i>`).
3. **3 Brand Colors**:
   - **Primer**: Deep Forest Tea Green (`#15803d` / `--color-primary` / `bg-primary`)
   - **Sekunder**: Warm Amber Brew (`#b45309` / `--color-secondary` / `bg-secondary`)
   - **Aksen**: Sky Telemetry Blue (`#0284c7` / `--color-accent` / `bg-accent`)
4. **No Vibe-Coding Slop**:
   - Refuse inline `rand()` in blade views. Datasets must be cleanly mapped from service/controller.
   - Refuse native browser `alert()` for user interactions; use the in-app toast notification system (`window.notify(message, type)`).
   - Headings are upright roman (`font-style: normal`), never italicized headings.
   - All interactive controls must support tactile press feedback (`active:translate-y-px`).
   - Zero horizontal overflow down to 320px mobile viewport (`overflow-x: clip`).
