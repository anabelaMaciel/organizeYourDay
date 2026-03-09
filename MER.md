# 🗄️ MER — Proyecta tu Día
> Stack: Symfony 7 · PHP 8.3 · Doctrine ORM · SQLite

---

## Diagrama de Entidades y Relaciones

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                              NÚCLEO GLOBAL                                   │
└─────────────────────────────────────────────────────────────────────────────┘

┌──────────────┐         ┌──────────────────┐         ┌───────────────────┐
│    User      │ 1───N   │    DayNote        │         │     Alert         │
│──────────────│         │──────────────────│         │───────────────────│
│ id           │         │ id               │         │ id                │
│ name         │         │ date (date)       │         │ time (time)       │
│ photo        │         │ content (text)    │         │ message (string)  │
│ bio          │         │ user_id (FK)      │         │ days (json)       │
│ welcome_msg  │         └──────────────────┘         │ sound (string)    │
└──────────────┘                                      │ active (bool)     │
       │                                              │ snooze (int min)  │
       │ 1                                            └───────────────────┘
       │
       │
┌──────┴──────────────────────────────────────────────────────────────────┐
│                           MÓDULO FACULTAD                                │
└──────────────────────────────────────────────────────────────────────────┘

┌──────────────┐         ┌──────────────────┐         ┌───────────────────┐
│   Materia    │ 1───N   │ HorarioMateria   │         │  FechaImportante  │
│──────────────│         │──────────────────│         │───────────────────│
│ id           │         │ id               │         │ id                │
│ name         │         │ day (string)     │         │ title             │
│ teacher      │         │ start_time       │         │ date (date)       │
│ quarter (int)│         │ end_time         │         │ type (string)     │
│ color (hex)  │         │ classroom        │         │ description       │
│ year (int)   │         │ materia_id (FK)  │         └───────────────────┘
└──────┬───────┘         └──────────────────┘
       │ 1
       ├──────────────── N ──────────────────────┐
       │                                         │
┌──────┴───────────────┐          ┌──────────────┴──────┐
│  TrabajoPractico     │          │    Evaluacion        │
│──────────────────────│          │─────────────────────│
│ id                   │          │ id                   │
│ title                │          │ type (string)        │
│ description (text)   │          │ date (date)          │
│ due_date (date)      │          │ grade (float,null)   │
│ status (string)      │          │ notes (text,null)    │
│ materia_id (FK)      │          │ materia_id (FK)      │
└──────────────────────┘          └─────────────────────┘

  STATUS en TrabajoPractico:
  pendiente | en_progreso | entregado | vencido


┌──────────────────────────────────────────────────────────────────────────┐
│                            MÓDULO TRABAJO                                │
└──────────────────────────────────────────────────────────────────────────┘

┌─────────────────────┐    ┌──────────────────────┐    ┌──────────────────┐
│       Tarea         │    │   HorarioLaboral      │    │      Duda        │
│─────────────────────│    │──────────────────────│    │──────────────────│
│ id                  │    │ id                   │    │ id               │
│ title               │    │ date (date)          │    │ title            │
│ description (text)  │    │ start_time           │    │ content (text)   │
│ status (string)     │    │ end_time             │    │ image (string,n) │
│ priority (string)   │    │ target_hours (float) │    │ date (date)      │
│ due_date (date,null)│    │ worked_hours (float) │    │ resolved (bool)  │
└─────────────────────┘    └──────────────────────┘    └──────────────────┘

  STATUS en Tarea:              PRIORITY en Tarea:
  pendiente | en_progreso       alta | media | baja
  | terminado


┌──────────────────────────────────────────────────────────────────────────┐
│                         MÓDULO EMPRENDIMIENTO                            │
└──────────────────────────────────────────────────────────────────────────┘

┌──────────────────┐   ┌──────────────────┐   ┌───────────────────────────┐
│    Entrega       │   │    Material      │   │       Proveedor           │
│──────────────────│   │──────────────────│   │───────────────────────────│
│ id               │   │ id               │   │ id                        │
│ product          │   │ name             │   │ name                      │
│ client           │   │ quantity (float) │   │ contact (string)          │
│ due_date (date)  │   │ unit (string)    │   │ material_supplied         │
│ status (string)  │   │ notes (text,n)   │   │ reference_price (float,n) │
│ notes (text,n)   │   └──────────────────┘   │ notes (text,n)            │
└──────────────────┘                          └───────────────────────────┘

  STATUS en Entrega:          UNIT en Material:
  preparando | listo          kg | g | unidad | metro
  | enviado | entregado       | litro | rollo | otro

┌──────────────────────────┐   ┌──────────────────────────┐
│   HorarioEmprendimiento  │   │       Inspiracion        │
│──────────────────────────│   │──────────────────────────│
│ id                       │   │ id                       │
│ day (string)             │   │ image (string)           │
│ start_time               │   │ description (text,null)  │
│ end_time                 │   │ category (string)        │
└──────────────────────────┘   └──────────────────────────┘

  CATEGORY en Inspiracion:
  referencia_diseño | modelo_imprimir | color | estilo | otro
```

---

## Relaciones en detalle

| Entidad A | Cardinalidad | Entidad B | Descripción |
|---|---|---|---|
| Materia | 1 → N | HorarioMateria | Una materia tiene varios horarios semanales |
| Materia | 1 → N | TrabajoPractico | Una materia tiene varios TPs |
| Materia | 1 → N | Evaluacion | Una materia tiene varios exámenes |

> **Nota**: User no tiene FK en todas las entidades porque la app es personal (un solo usuario). Si en el futuro escala a multi-usuario, se agrega `user_id` como FK en todas las tablas principales.

---

## Entidades Symfony — Detalle de campos y tipos Doctrine

### User
```php
#[ORM\Entity]
class User {
    int $id                    // PK, autoincrement
    string $name               // not null
    ?string $photo             // nullable, ruta al archivo
    ?string $bio               // nullable
    ?string $welcomeMessage    // nullable
}
```

### DayNote
```php
#[ORM\Entity]
class DayNote {
    int $id
    \DateTimeInterface $date   // UNIQUE — una nota por día
    string $content            // TEXT
}
```

### Alert
```php
#[ORM\Entity]
class Alert {
    int $id
    \DateTimeInterface $time   // TIME — hora de disparo
    string $message
    array $days                // JSON — ['lunes','miercoles','viernes']
    string $sound              // 'bell' | 'chime' | 'beep'
    bool $active               // default: true
    int $snoozeMinutes         // default: 10
}
```

### Materia
```php
#[ORM\Entity]
class Materia {
    int $id
    string $name
    string $teacher
    int $quarter               // 1 o 2
    int $year                  // 2024, 2025...
    string $color              // HEX — para calendario
}
```

### HorarioMateria
```php
#[ORM\Entity]
class HorarioMateria {
    int $id
    string $day                // 'lunes'...'sabado'
    \DateTimeInterface $startTime
    \DateTimeInterface $endTime
    string $classroom
    Materia $materia           // ManyToOne
}
```

### TrabajoPractico
```php
#[ORM\Entity]
class TrabajoPractico {
    int $id
    string $title
    ?string $description
    \DateTimeInterface $dueDate
    string $status             // pendiente | en_progreso | entregado | vencido
    Materia $materia           // ManyToOne
}
```

### Evaluacion
```php
#[ORM\Entity]
class Evaluacion {
    int $id
    string $type               // parcial | final | recuperatorio | coloquio
    \DateTimeInterface $date
    ?float $grade              // nullable — se carga después
    ?string $notes
    Materia $materia           // ManyToOne
}
```

### FechaImportante
```php
#[ORM\Entity]
class FechaImportante {
    int $id
    string $title
    \DateTimeInterface $date
    string $type               // inscripcion | inicio_cursada | fin_cursada | entrega | otro
    ?string $description
}
```

### Tarea
```php
#[ORM\Entity]
class Tarea {
    int $id
    string $title
    ?string $description
    string $status             // pendiente | en_progreso | terminado
    string $priority           // alta | media | baja
    ?\DateTimeInterface $dueDate
}
```

### HorarioLaboral
```php
#[ORM\Entity]
class HorarioLaboral {
    int $id
    \DateTimeInterface $date   // UNIQUE — uno por día
    \DateTimeInterface $startTime
    \DateTimeInterface $endTime
    float $targetHours
    float $workedHours         // default: 0.0
}
```

### Duda
```php
#[ORM\Entity]
class Duda {
    int $id
    string $title
    string $content            // TEXT
    ?string $image             // ruta al archivo
    \DateTimeInterface $date
    bool $resolved             // default: false
}
```

### Entrega
```php
#[ORM\Entity]
class Entrega {
    int $id
    string $product
    string $client
    \DateTimeInterface $dueDate
    string $status             // preparando | listo | enviado | entregado
    ?string $notes
}
```

### Material
```php
#[ORM\Entity]
class Material {
    int $id
    string $name
    float $quantity
    string $unit               // kg | g | unidad | metro | litro | rollo | otro
    ?string $notes
}
```

### HorarioEmprendimiento
```php
#[ORM\Entity]
class HorarioEmprendimiento {
    int $id
    string $day                // 'lunes'...'domingo'
    \DateTimeInterface $startTime
    \DateTimeInterface $endTime
}
```

### Inspiracion
```php
#[ORM\Entity]
class Inspiracion {
    int $id
    string $image              // ruta al archivo subido
    ?string $description
    string $category           // referencia_diseño | modelo_imprimir | color | estilo | otro
}
```

### Proveedor
```php
#[ORM\Entity]
class Proveedor {
    int $id
    string $name
    string $contact            // teléfono o email
    string $materialSupplied
    ?float $referencePrice
    ?string $notes
}
```

---

## Resumen: 16 entidades en total

| # | Entidad | Módulo |
|---|---|---|
| 1 | User | Global |
| 2 | DayNote | Global |
| 3 | Alert | Global |
| 4 | Materia | Facultad |
| 5 | HorarioMateria | Facultad |
| 6 | TrabajoPractico | Facultad |
| 7 | Evaluacion | Facultad |
| 8 | FechaImportante | Facultad |
| 9 | Tarea | Trabajo |
| 10 | HorarioLaboral | Trabajo |
| 11 | Duda | Trabajo |
| 12 | Entrega | Emprendimiento |
| 13 | Material | Emprendimiento |
| 14 | HorarioEmprendimiento | Emprendimiento |
| 15 | Inspiracion | Emprendimiento |
| 16 | Proveedor | Emprendimiento |

---

## Orden sugerido para crear migraciones en Symfony

```bash
# 1. Sin dependencias
php bin/console make:entity User
php bin/console make:entity DayNote
php bin/console make:entity Alert
php bin/console make:entity FechaImportante
php bin/console make:entity Tarea
php bin/console make:entity HorarioLaboral
php bin/console make:entity Duda
php bin/console make:entity Entrega
php bin/console make:entity Material
php bin/console make:entity HorarioEmprendimiento
php bin/console make:entity Inspiracion
php bin/console make:entity Proveedor

# 2. Con FK (después de crear Materia)
php bin/console make:entity Materia
php bin/console make:entity HorarioMateria       # FK → Materia
php bin/console make:entity TrabajoPractico      # FK → Materia
php bin/console make:entity Evaluacion           # FK → Materia

# 3. Migración final
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```


### USER ->
"me gustaria agregar "Nota" para materias, asi voy viendo que notas voy teniendo por examen en las materias, ya que todas son anuales (al menos en primer ano) y que esta nota salga arriba del nombre de cada materia, para tener una visualizacion mejor y que a medida que vaya teniendo un resultado de un examne, me vaya sacando el promedio, me explico?"

### Response

'Entendido perfectamente. La buena noticia es que no hace falta una entidad nueva — ya tenés Evaluacion con el campo grade (float, nullable). Solo hay dos ajustes:
1. En la entidad Materia: el campo quarter no aplica para materias anuales, así que lo hacemos opcional:'

// Antes:
int $quarter  // 1 o 2

// Después:
?string $regime  // 'anual' | 'cuatrimestral' — nullable, default: 'anual'

'2. En la lógica: el promedio se calcula dinámicamente desde las Evaluacion que tengan grade != null de esa materia. En Symfony sería algo así en el repositorio:'

// EvaluacionRepository.php
public function getAverageByMateria(int $materiaId): ?float
{
    return $this->createQueryBuilder('e')
        ->select('AVG(e.grade)')
        ->where('e.materia = :id AND e.grade IS NOT NULL')
        ->setParameter('id', $materiaId)
        ->getQuery()
        ->getSingleScalarResult();
}
```

**3. En la UI** (para el brief de v0.dev), cada card de materia quedaría así:
```
┌─────────────────────────┐
│  Promedio: 7.5 ★        │  ← destacado arriba, en melocotón
│  ─────────────────────  │
│  Sistemas I             │  ← nombre
│  Prof. García           │
│  📝 2 exámenes rendidos │
└─────────────────────────┘

'Si todavía no hay notas cargadas, muestra Promedio: — en gris suave.'

