# Prueba Técnica

## 1. Esquema de base de datos para una plataforma de blogs

La carpeta 1.Base de datos incluye el script SQL y el modelo relacional.

---

## 2. Función para determinar indices; descripción del Problema

Dada una lista de enteros (numeros) y un entero (objetivo), se requiere encontrar los índices de los dos números que sumen el objetivo.
La carpeta 2.Funcion Indices contiene dos carpetas internas; javaFuncion y phpFuncion, a continuación se listan los detalles relevantes para testear.

---

## Requisitos de Ejecución

### 2.1. PHP

* Intérprete de PHP (versión 7.0 o superior recomendada).

### 2.2. Java

* Java Development Kit (JDK) instalado (versión 8 o superior recomendada).
* El archivo compilado `Main.class` debe estar en el mismo directorio que se ejecuta.

---

## Instrucciones de Prueba

### 2.2.1. Prueba de la Solución en PHP

El archivo indices.php está configurado con un arreglo y objetivo de prueba por defecto:

* **Array:** `[1, 4, 5, 4, 8]`
* **Objetivo:** `8`

#### **Ejecución desde la terminal php:**

php indices.php

Salida esperada:

---
Array de búsqueda: [1, 4, 5, 4, 8]

---
Indices encontrados: [2, 4]

#### **También puede ejecutarse desde navegador**

---

### 2.2.2. Prueba de la Solución en JAVA

El archivo Main.java (y su compilado Main.class) está configurado con un arreglo y objetivo de prueba por defecto:

* **Array:** `[4, 2, 4, 7, 11, 15]`
  
* **Objetivo:** `8`

#### **Ejecución desde la terminal java:**

java Main

Salida esperada:

---

Indices encontrados: [0, 2]

---

En caso de querer ajustar el array, se requiere compilar antes de ejecutar el Main nuevamente

javac Main.java

---

## 3. Sistema de gestión de bibliotecas

La carpeta 3.Bibliotecas contiene dos carpetas internas; javaBiblioteca y phpBiblioteca, a continuación se listan los detalles relevantes para testear.

---

## 3.1. Instrucciones de Prueba

### 3.1.1. Prueba de la Solución en PHP

Se aconseja ejecutarse desde navegador en un entorno lampp de su preferencia; el sistema tiene una interfaz sencilla que permite interactuar con el usuario.

### 3.1.2. Prueba de la Solución en JAVA

#### **Ejecución desde la terminal:**

java Main

El sistema tiene una interfaz sencilla que permite interactuar con el usuario.

En caso de querer ajustar algo en el código, se requiere compilar antes de ejecutar el Main nuevamente:

javac -encoding UTF-8 Main.java

---

## Adicional

En el repositorio https://github.com/ljgarciap/biblioteca está disponible un desarrollo previo en Laravel en el que había implementado una solución sencilla para una biblioteca pública de bajos recursos en el Cauca.

---
