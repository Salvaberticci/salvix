# 🏎️ Salvix - Premium Restaurant Management System

![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![Design](https://img.shields.io/badge/Design-Ferrari_Chiaroscuro-DA291C?style=for-the-badge)

**Salvix** es un ecosistema editorial de gestión para restaurantes, diseñado bajo la estética industrial de Ferrari: precisión, velocidad y elegancia. El sistema integra Inteligencia Artificial avanzada, gestión bimonetaria en tiempo real y una experiencia de usuario cinematográfica.

---

## 🎨 Ferrari Design System (`design.md`)

El núcleo visual de Salvix se basa en el **Chiaroscuro**: un contraste absoluto entre superficies *Negro Vacío* y paneles *Blanco Editorial*.

- **Precisión Industrial**: Radios de borde de 2px en todos los componentes.
- **Rojo Ferrari (`#DA291C`)**: Utilizado quirúrgicamente solo para llamadas a la acción críticas.
- **Tipografía Editorial**: Títulos en *Playfair Display* (narrativa de lujo) y cuerpo en *Inter* (precisión técnica).

---

## 🚀 Funcionalidades Principales

### 🧠 AI RAG Engine (Cerebro Digital)
Integración nativa con **Google Gemini / OpenAI / Groq**. El sistema utiliza **RAG (Retrieval-Augmented Generation)** para inyectar el menú, ingredientes y precios en tiempo real al prompt de la IA, permitiendo que el chatbot responda con exactitud absoluta sobre el inventario.

### 💸 Hub Financiero Bimonetario
- **Sincronización BCV Reactiva**: Conexión automática con *DolarAPI* para actualizar la tasa oficial cada 60 minutos sin recargar la página.
- **Cálculos Duales**: Conversión instantánea de precios USD a Bs en el catálogo y tickets de pago.

### 📦 Módulo de Delivery & Logística
- **Captura Inteligente**: Formulario dinámico para recopilar nombre, teléfono y dirección exacta del cliente.
- **Tipo de Entrega Dual**: Soporte para *Delivery a Domicilio* y *Retiro en Tienda*.
- **Trazabilidad de Pedidos**: Los datos de contacto viajan íntegramente desde el catálogo hasta el panel de cocina.

### 💳 Hub de Pagos & Verificación (Finalización Premium)
- **Wizard de 4 Pasos**: Una experiencia de checkout cinematográfica (Resumen -> Entrega -> Método -> Reporte).
- **Gestión de Bancos**: Panel administrativo para configurar cuentas de Pago Móvil, Zelle y Efectivo.
- **Verificación Visual**: Los administradores pueden ver el capture de pantalla del pago y validar referencias antes de procesar el pedido.
- **Flujo Automatizado**: Al confirmar un pago, el pedido se mueve instantáneamente a los monitores de cocina.

### 🎨 Motor de Temas Dinámico (Theme Engine)
- **Personalización Absoluta**: Gestión de variables CSS (colores, fuentes y bordes) directamente desde el panel de control, sin tocar una línea de código.
- **Plantillas Predefinidas**: Incluye 5 estéticas de alta conversión (Ferrari Chiaroscuro, Emerald, Nordic, Retro y Cyberpunk).
- **Branding**: Capacidad de subir logotipo personalizado o utilizar tipografía dinámica generada al vuelo.

### 🍽️ Punto de Venta Interno (POS) & Operaciones
- **POS Integrado**: Interfaz rápida y limpia para que meseros y cajeros tomen pedidos directamente en el local, asignándolos a mesas específicas.
- **Kanban Operativo Mejorado**: Tablero de control en tiempo real para cocina con desglose detallado de platos, cantidades y diseño de alto contraste (Trello-style).
- **Dashboard de Alto Rendimiento**: Métricas reales y gráficos dinámicos sincronizados con el flujo de ventas diarias de los últimos 7 días.
- **Control de Inventario**: Gestión estricta de ingredientes, costos y niveles de alerta por merma o bajo stock.

---

## 🛠️ Stack Tecnológico

- **Backend**: Laravel 12 + PHP 8.2
- **Frontend**: Pico CSS v2 (Customized) + Alpine.js + GSAP (Animaciones)
- **Base de Datos**: MySQL
- **Servicios**: DolarAPI, Google AI / Anthropic / OpenAI

---

## 📦 Instalación

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/Salvaberticci/salvix.git
   cd salvix
   ```

2. **Instalar dependencias:**
   ```bash
   composer install
   ```

3. **Configurar entorno:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migraciones y Datos iniciales:**
   ```bash
   php artisan migrate --seed
   ```

5. **Acceso Admin Predeterminado:**
   - **Usuario**: `admin@salvix.com`
   - **Password**: `password`

---

## 🤝 Contribuciones e Implementación

Este proyecto ha sido diseñado para despliegue rápido en servidores compartidos (Namecheap/cPanel) utilizando activos estáticos optimizados, eliminando la necesidad de compiladores de Node.js en producción.

---

**Salvix Restaurant System** - *Precision is not an option, it's a standard.*
