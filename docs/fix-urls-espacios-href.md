# Fix: URLs duplicadas por espacios sobrantes en enlaces internos

**Prioridad:** Alta · **Origen:** auditoría DinoRANK (bloque `urls_lentas`)

## Diagnóstico (rastreo de las 61 URLs del sitemap, 24/09/2026)

| Página que contiene el enlace | Enlace erróneo (href) | Texto aprox. |
|---|---|---|
| /tratamientos-de-peluqueria-en-madrid/ | `https://dimsalon.es/tratamiento-gloss-intenso/%20%20` | Gloss Intenso |
| /tratamientos-de-peluqueria-en-madrid/ | `https://dimsalon.es/tratamiento-de-infusion-capilar-en-madrid/%20` | Infusión capilar |
| /tratamientos-de-peluqueria-en-madrid/ | `https://dimsalon.es/tratamiento-de-bioplastia-capilar-en-madrid/%20` | Bioplastia |
| /tratamiento-gloss-intenso/ | `https://dimsalon.es/tratamiento-de-bioplastia-capilar-en-madrid/%20` | Bioplastia |
| /prensa/ (externo) | `https://www.vozpopuli.com/dolcevita/coloracion-natural-organica-vegana.html%20` | Vozpópuli |

El servidor ya responde 301 de `/…/%20` a la URL limpia, pero el enlace interno
sigue apuntando a una redirección (desperdicio de rastreo y variantes duplicadas).

## Corrección manual en Elementor (definitiva)

1. Editar cada página de la tabla con Elementor.
2. Seleccionar el botón/imagen/texto enlazado → campo **Enlace**.
3. Borrar los espacios al final de la URL (colocar el cursor al final y pulsar Retroceso hasta la `/`).
4. **Actualizar** y, si hay caché (WP Rocket, LiteSpeed…), purgarla.
5. Elementor → Herramientas → **Regenerar CSS y datos**.

## Red de seguridad

`wordpress/mu-plugins/dim-trim-href-spaces.php`: copiarlo a `wp-content/mu-plugins/`.
Limpia en el HTML final cualquier `href` que termine en espacio/`%20`, para que no
vuelva a ocurrir aunque alguien pegue un enlace con espacio.

## Verificación

```bash
for u in tratamientos-de-peluqueria-en-madrid tratamiento-gloss-intenso prensa; do
  curl -s "https://dimsalon.es/$u/" | grep -oE 'href="[^"]*%20"'
done   # no debe devolver nada
```

Después, volver a lanzar el rastreo en DinoRANK y solicitar reindexación en Search Console.
