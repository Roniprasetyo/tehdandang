# AGENTS.md — Teh Dandang Development Guidelines

## Design Discipline: Hallmark Active
This project follows the **Hallmark** anti-AI-slop design skill and guidelines located in:
- Skill instructions: `.agents/skills/hallmark/SKILL.md` and `references/`
- Cursor rules: `.cursor/rules/hallmark.mdc`
- Locked system: `design.md`
- Token source: `public/css/tokens.css`

### Core Rules for UI & Code Generation:
1. **No Generic AI Slop**: Refuse predictable purple/indigo gradients, floaty blobs, generic copy, and fabricated numbers. Use genuine FMCG distribution terminology (GT/MT channels, SAP B1 integration, RO/ROA, Sales Visit GPS).
2. **Typography**: Display font is `Outfit` (roman only, never italic headings). Body font is `Plus Jakarta Sans`. Numeric metrics must use `tabular-nums` (`tabular-data`).
3. **Tactile Interaction**: Buttons and interactive controls must have all 8 states where applicable (default, hover, active with 1px press, focus-visible ring, disabled, loading, error, success).
4. **Responsive Integrity**: Test viewports down to 320px without horizontal overflow (`overflow-x: clip`).
5. **Code Quality**: Maintain Laravel MVC standards, Blade component modularity, and clean Alpine.js reactivity.
