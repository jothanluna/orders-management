<?php
require_once __DIR__ . '/../../../config/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard - Sucursal Ejido</title>
   <script>
    const BASE_URL = '<?php echo BASE_URL; ?>';
   </script>
   <script src="https://cdn.tailwindcss.com"></script>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   <style>
       
         [contenteditable="true"].bg-yellow-100 {
            background-color: rgba(254, 243, 199, 0.5);
          }
          
          [contenteditable="true"].bg-blue-100 {
            background-color: rgba(219, 234, 254, 0.5);
          }
          
          [contenteditable="true"].bg-green-100 {
            background-color: rgba(209, 250, 229, 0.5);
            transition: background-color 1s;
          }
          
          [contenteditable="true"].bg-red-100 {
            background-color: rgba(254, 226, 226, 0.5);
          }
       
   </style>
</head>
<body class="bg-gray-100">
   <nav class="bg-white shadow">
       <div class="max-w-7xl mx-auto px-4">
           <div class="flex h-16 justify-between items-center">
               <h1 class="text-xl font-bold">Sucursal Ejido</h1>
               <a href="<?php echo BASE_URL; ?>?action=logout">Cerrar Sesión</a>
           </div>
       </div>
   </nav>

   <main class="max-w-7xl mx-auto px-4 py-8">
       <!-- Tabs para días -->
       <div class="mb-6 bg-white rounded-lg shadow">
           <nav class="flex border-b">
               <button class="tab-btn active px-6 py-3 border-b-2" onclick="loadData(0)">Hoy</button>
               <button class="tab-btn px-6 py-3" onclick="loadData(1)">Ayer</button>
               <button class="tab-btn px-6 py-3" onclick="loadData(2)">Hace 2 días</button>
               <button class="tab-btn px-6 py-3" onclick="loadData(3)">Hace 3 días</button>
               <button class="tab-btn px-6 py-3" onclick="loadData(4)">Hace 4 días</button>
           </nav>
       </div>

       <!-- Totales -->
       <div class="grid grid-cols-4 gap-4 mb-6">
           <div class="bg-white rounded-lg shadow p-4">
               <h3 class="text-sm text-gray-500">Efectivo Neto</h3>
               <p id="efectivo-total" class="text-2xl font-bold mt-1">$0.00</p>
           </div>
           <div class="bg-white rounded-lg shadow p-4">
               <h3 class="text-sm text-gray-500">Transferencias</h3>
               <p id="transferencia-total" class="text-2xl font-bold mt-1">$0.00</p>
           </div>
           <div class="bg-white rounded-lg shadow p-4">
               <h3 class="text-sm text-gray-500">Tarjetas</h3>
               <p id="tarjeta-total" class="text-2xl font-bold mt-1">$0.00</p>
           </div>
           <div class="bg-white rounded-lg shadow p-4">
               <h3 class="text-sm text-gray-500">Total Envíos</h3>
               <p id="envios-total" class="text-2xl font-bold mt-1">$0.00</p>
           </div>
       </div>

       <!-- Botón Agregar y Filtro -->
       <div class="mb-6 flex justify-between items-center">
           <select id="metodo-pago-filter" class="w-1/2 p-2 border rounded" onchange="filterByPaymentMethod()">
               <option value="">Todos los métodos de pago</option>
               <option value="Efectivo">Efectivo</option>
               <option value="Transferencia">Transferencia</option>
               <option value="Tarjeta">Tarjeta</option>
           </select>
           <button onclick="addNewOrder()" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
               Agregar Nueva Orden
           </button>
       </div>
       <!-- Tabla -->
       <div class="bg-white rounded-lg shadow">
            <div class="max-h-[60vh] overflow-y-auto">
                <table class="min-w-full border-collapse table-auto">
                    <thead class="bg-gray-50 sticky top-0 shadow z-10">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase w-16">Órd</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase w-16">Bur</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase w-16">Beb</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Tarjeta</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Método</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total sin env</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Envío</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Repartidor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dinero Rec.</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Repa.</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase w-16">Acc</th>
                        </tr>
                    </thead>
                    <tbody id="orders-table" class="divide-y divide-gray-200 bg-white">
                        <!-- El contenido dinámico -->
                    </tbody>
                    <tfoot id="orders-totals" class="bg-gray-50 sticky bottom-0 shadow z-10">
                        <!-- El contenido dinámico -->
                    </tfoot>
                </table>
            </div>
        </div>
  </main>

  <script>
  let currentData = [];
  let currentDay = 0;
  let currentFilter = '';
    // Variables para el polling
    let lastUpdate = Math.floor(Date.now() / 1000);
    let pollingInterval;


  async function loadData(day = 0) {
        try {
            const response = await fetch(`${BASE_URL}/../src/Controllers/DashboardController.php?action=stats&sucursal=ejido&periodo=dia&day=${day}`);
            const data = await response.json();
            console.log('Datos recibidos:', data); // Para debug

            if (data.success) {
                updateTotals(data.data);
                updateTabs(day);

                const ordersResponse = await fetch(`${BASE_URL}/../src/Controllers/DashboardController.php?action=orders&sucursal=ejido&day=${day}`);
                const ordersData = await ordersResponse.json();
                
                if (ordersData.success) {
                    currentData = ordersData.data;
                    // Aplicar filtro actual o mostrar todos los datos
                    const filteredData = currentFilter 
                        ? currentData.filter(order => order.metodo_pago?.trim().toLowerCase() === currentFilter.trim().toLowerCase())
                        : currentData;
                    updateTable(filteredData);
                }
            }
        } catch (error) {
            console.error('Error al cargar datos:', error);
        }
    }

    async function addNewOrder() {
        try {
            const response = await fetch(`${BASE_URL}/../src/Controllers/DashboardController.php?action=add`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    sucursal: 'ejido',
                    day: currentDay,
                    nombre: 'Nuevo Cliente'
                })
            });

            const result = await response.json();
            if (result.success) {
                // Recargar todos los datos para asegurar que los totales se actualicen correctamente
                await loadData(currentDay);
            } else {
                console.error('Error al agregar la orden:', result.error);
                alert('Error al agregar la orden');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al agregar la orden');
        }
    }

    async function deleteOrder(id) {
    if (!confirm('¿Estás seguro de eliminar esta orden?')) return;
    
    try {
        const response = await fetch(`${BASE_URL}/../src/Controllers/DashboardController.php?action=delete`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                sucursal: 'ejido',
                day: currentDay,
                id: id
            })
        });

        const result = await response.json();
        if (result.success) {
            loadData(currentDay);
        } else {
            alert('Error al eliminar la orden');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error de conexión');
    }
}

function updateTable(orders) {
    const tbody = document.getElementById('orders-table');
    const tfoot = document.getElementById('orders-totals');

    tbody.innerHTML = orders.map(order => {
        // Determina el color de la celda basado en el método de pago
        let colorClass = '';
        if (order.metodo_pago === 'Efectivo') {
            colorClass = 'bg-green-500 text-white';
        } else if (order.metodo_pago === 'Transferencia') {
            colorClass = 'bg-blue-500 text-white';
        } else if (order.metodo_pago === 'Tarjeta') {
            colorClass = 'bg-purple-500 text-white';
        }

        return `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4" contenteditable="true" data-id="${order.id}" data-field="nombre">${order.nombre || ''}</td>
                <td class="px-6 py-4 text-center w-16" contenteditable="true" data-id="${order.id}" data-field="ordenes">${order.ordenes || 0}</td>
                <td class="px-6 py-4 text-center w-16" contenteditable="true" data-id="${order.id}" data-field="burritos">${order.burritos || 0}</td>
                <td class="px-6 py-4 text-center w-16" contenteditable="true" data-id="${order.id}" data-field="bebidas">${order.bebidas || 0}</td>
                <td class="px-6 py-4" contenteditable="true" data-id="${order.id}" data-field="total">$${parseFloat(order.total || 0).toFixed(2)}</td>
                <td class="px-6 py-4">$${(parseFloat(order.total || 0) * 1.04).toFixed(2)}</td> <!-- Total + 4% comisión -->
                <td class="px-6 py-4 ${colorClass}">
                    <select class="w-full bg-transparent text-center"
                            onchange="changeCellColor(this); updateField(${order.id}, 'metodo_pago', this)">
                        <option value="">Seleccionar método</option>
                        <option value="Efectivo" ${order.metodo_pago === 'Efectivo' ? 'selected' : ''}>Efectivo</option>
                        <option value="Transferencia" ${order.metodo_pago === 'Transferencia' ? 'selected' : ''}>Transferencia</option>
                        <option value="Tarjeta" ${order.metodo_pago === 'Tarjeta' ? 'selected' : ''}>Tarjeta</option>
                    </select>
                </td>
                <td class="px-6 py-4">$${(parseFloat(order.total || 0) - parseFloat(order.envio || 0)).toFixed(2)}</td> <!-- Cambio calculado -->
                <td class="px-6 py-4" contenteditable="true" data-id="${order.id}" data-field="envio">$${parseFloat(order.envio || 0).toFixed(2)}</td>
                <td class="px-6 py-4">
                    <select class="w-full bg-transparent" onchange="updateField(${order.id}, 'repartidor', this)">
                        <option value="Joys" ${order.repartidor === 'Joys' ? 'selected' : ''}>Joys</option>
                        <option value="Pickup" ${order.repartidor === 'Pickup' ? 'selected' : ''}>Pickup</option>
                        <option value="Interno" ${order.repartidor === 'Interno' ? 'selected' : ''}>Interno</option>
                    </select>
                </td>
                <td class="px-6 py-4 text-center">
                    <input 
                        type="checkbox" 
                        id="dinero_recibido_${order.id}"
                        name="dinero_recibido_${order.id}"
                        ${order.dinero_recibido == 1 ? 'checked' : ''} 
                        onchange="updateField(${order.id}, 'dinero_recibido', this)">
                </td>
                <td class="px-6 py-4" contenteditable="true" data-id="${order.id}" data-field="nombre_repartidor">${order.nombre_repartidor || ''}</td>
                <td class="px-6 py-4 text-center w-16">
                    <button onclick="deleteOrder(${order.id})" class="text-red-600 hover:text-red-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </td>
            </tr>`;
    }).join('');

    addKeyListeners(); // Aplicar los eventos a las celdas generadas dinámicamente
    const totals = calculateTotals(orders);
    updateFooter(totals, tfoot);
}


    function addKeyListeners() {
        document.querySelectorAll('[contenteditable="true"]').forEach(element => {
            // Al enfocar, seleccionar el texto pero no borrar
            element.addEventListener('focus', function() {
                this.dataset.originalValue = this.innerText; // Guardar valor original
                window.getSelection().selectAllChildren(this); // Seleccionar todo el texto
                this.classList.add('bg-yellow-100'); // Indicador visual de edición
            });
    
            // Manejar teclas especiales
            element.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.blur(); // Confirmar al presionar Enter
                } else if (e.key === 'Escape') {
                    e.preventDefault();
                    this.innerText = this.dataset.originalValue; // Restaurar valor original
                    this.blur(); // Salir del modo edición
                }
            });
    
            // Mejorar el evento blur
            element.addEventListener('blur', function() {
                this.classList.remove('bg-yellow-100'); // Quitar indicador de edición
                
                // Solo actualizar si el valor cambió
                if (this.innerText !== this.dataset.originalValue) {
                    const id = this.getAttribute('data-id');
                    const field = this.getAttribute('data-field');
                    
                    // Indicador visual de "guardando"
                    this.classList.add('bg-blue-100');
                    
                    updateField(id, field, this)
                        .then(success => {
                            this.classList.remove('bg-blue-100');
                            if (success) {
                                // Mostrar brevemente un indicador de éxito
                                this.classList.add('bg-green-100');
                                setTimeout(() => this.classList.remove('bg-green-100'), 1000);
                            } else {
                                // Indicador de error
                                this.classList.add('bg-red-100');
                                setTimeout(() => this.classList.remove('bg-red-100'), 2000);
                            }
                        });
                }
            });
        });
    }


  async function updateField(id, field, element) {
    let value;
    
        if (field === 'dinero_recibido') {
            value = element.checked ? 1 : 0;
        } else if (element.tagName === 'SELECT') {
            value = element.value;
        } else {
            value = element.innerText.replace(/[$,]/g, '').trim();
        }
    
        try {
            const response = await fetch(`${BASE_URL}/../src/Controllers/DashboardController.php?action=update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    id: parseInt(id),
                    field,
                    value,
                    sucursal: 'ejido', // o 'palmeras' según la página
                    day: currentDay
                })
            });
    
            const data = await response.json();
            if (data.success) {
                // Solo recargar datos si es realmente necesario
                if (['total', 'metodo_pago', 'envio'].includes(field)) {
                    updateStatsTotals(); // Nueva función para actualizar solo los totales
                }
                return true;
            } else {
                console.error('Error:', data.error);
                return false;
            }
        } catch (error) {
            console.error('Error:', error);
            return false;
        }
    }
    
    async function updateStatsTotals() {
    try {
            const response = await fetch(`${BASE_URL}/../src/Controllers/DashboardController.php?action=stats&sucursal=ejido&periodo=dia&day=${currentDay}`);
            const data = await response.json();
            
            if (data.success) {
                updateTotals(data.data);
            }
        } catch (error) {
            console.error('Error al actualizar totales:', error);
        }
    }

  function calculateTotals(orders) {
      return orders.reduce((acc, order) => ({
          ordenes: acc.ordenes + parseInt(order.ordenes || 0),
          burritos: acc.burritos + parseInt(order.burritos || 0),
          bebidas: acc.bebidas + parseInt(order.bebidas || 0),
          total: acc.total + parseFloat(order.total || 0),
          paga_con: acc.paga_con + (parseFloat(order.total || 0) * 1.04), // Total + 4% comisión
          cambio: acc.cambio + (parseFloat(order.total || 0) - parseFloat(order.envio || 0)),
          envio: acc.envio + parseFloat(order.envio || 0)
      }), {
          ordenes: 0, burritos: 0, bebidas: 0,
          total: 0, paga_con: 0, cambio: 0, envio: 0
      });
  }

  function updateFooter(totals, tfoot) {
      tfoot.innerHTML = `
          <tr>
              <td class="px-6 py-4">TOTALES</td>
              <td class="px-6 py-4">${totals.ordenes}</td>
              <td class="px-6 py-4">${totals.burritos}</td>
              <td class="px-6 py-4">${totals.bebidas}</td>
              <td class="px-6 py-4">$${totals.total.toFixed(2)}</td>
              <td class="px-6 py-4">$${totals.paga_con.toFixed(2)}</td> <!-- Total + 4% -->
              <td class="px-6 py-4"></td>
              <td class="px-6 py-4">$${totals.cambio.toFixed(2)}</td> <!-- Cambio dinámico -->
              <td class="px-6 py-4">$${totals.envio.toFixed(2)}</td>
              <td colspan="3"></td>
          </tr>
      `;
  }

  function updateTotals(data) {
        if (!data) {
            console.warn('No hay datos para actualizar totales');
            return;
        }

        // Asegurarse de que los elementos existen antes de actualizar
        const efectivoTotal = document.getElementById('efectivo-total');
        const transferenciaTotal = document.getElementById('transferencia-total');
        const tarjetaTotal = document.getElementById('tarjeta-total');
        const enviosTotal = document.getElementById('envios-total');

        if (efectivoTotal) {
            efectivoTotal.textContent = `$${parseFloat(data.efectivo_neto || 0).toFixed(2)}`;
        }
        if (transferenciaTotal) {
            transferenciaTotal.textContent = `$${parseFloat(data.stats?.find(d => d.metodo_pago === 'Transferencia')?.monto || 0).toFixed(2)}`;
        }
        if (tarjetaTotal) {
            tarjetaTotal.textContent = `$${parseFloat(data.stats?.find(d => d.metodo_pago === 'Tarjeta')?.monto || 0).toFixed(2)}`;
        }
        if (enviosTotal) {
            enviosTotal.textContent = `$${parseFloat(data.envios || 0).toFixed(2)}`;
        }
    }

  function updateTabs(activeDay) {
      document.querySelectorAll('.tab-btn').forEach((btn, index) => {
          if (index === activeDay) {
              btn.classList.add('active', 'border-blue-500', 'text-blue-600');
              btn.classList.remove('border-transparent', 'text-gray-500');
          } else {
              btn.classList.remove('active', 'border-blue-500', 'text-blue-600');
              btn.classList.add('border-transparent', 'text-gray-500');
          }
      });
      currentDay = activeDay;
  }

  function filterByPaymentMethod() {
        const method = document.getElementById('metodo-pago-filter').value;
        localStorage.setItem('currentFilter', method); // Guardar filtro en localStorage
        currentFilter = method;
        const filteredData = method
            ? currentData.filter(order => order.metodo_pago?.trim().toLowerCase() === method.trim().toLowerCase())
            : currentData;
        updateTable(filteredData);
    }

    function restoreFilter() {
        const savedFilter = localStorage.getItem('currentFilter');
        if (savedFilter) {
            document.getElementById('metodo-pago-filter').value = savedFilter;
            filterByPaymentMethod();
        }
    }

  
    function startPolling() {
        stopPolling(); // Detener polling existente
        
        pollingInterval = setInterval(() => {
            // No hacer polling si hay elementos en edición
            if (document.querySelector('.bg-yellow-100, .bg-blue-100')) {
                console.log('Usuario editando, polling pausado');
                return;
            }
            
            checkUpdates();
        }, 20000); // Usar un único intervalo más largo (20 segundos)
    }

    function stopPolling() {
        if (pollingInterval) {
            clearInterval(pollingInterval);
            console.log('Polling detenido');
        }
    }

    async function checkUpdates() {
        try {
            const response = await fetch(`${BASE_URL}/fetch-updates.php?sucursal=ejido&last_update=${lastUpdate}&day=${currentDay}`);
            const data = await response.json();

            if (data.success) {
                if (data.hasChanges) {
                    console.log('Cambios detectados, actualizando datos...');
                    updateTotals(data.stats);
                    if (data.orders) {
                        currentData = data.orders;
                        const filteredData = currentFilter 
                            ? currentData.filter(order => order.metodo_pago?.trim().toLowerCase() === currentFilter.trim().toLowerCase())
                            : currentData;
                        updateTable(filteredData);
                    }
                }
                lastUpdate = data.timestamp;
            } else {
                console.error('Error en la verificación:', data.error);
            }
        } catch (error) {
            console.error('Error en el polling:', error);
        }
    }


    document.addEventListener('DOMContentLoaded', startPolling);

    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            stopPolling();
        } else {
            startPolling();
        }
    });

    function changeCellColor(selectElement) {
        const cell = selectElement.closest('td'); // Encuentra la celda (td) que contiene el select
        const value = selectElement.value; // Obtiene el valor seleccionado

        // Resetea las clases de color
        cell.classList.remove('bg-green-500', 'bg-blue-500', 'bg-purple-500', 'text-white');

        // Aplica el color correspondiente al valor seleccionado
        if (value === 'Efectivo') {
            cell.classList.add('bg-green-500', 'text-white'); // Fondo verde, texto blanco
        } else if (value === 'Transferencia') {
            cell.classList.add('bg-blue-500', 'text-white'); // Fondo azul, texto blanco
        } else if (value === 'Tarjeta') {
            cell.classList.add('bg-purple-500', 'text-white'); // Fondo morado, texto blanco
        }
    }


    // Llama a `restoreFilter` al cargar los datos por primera vez
    loadData(0).then(() => restoreFilter());
  </script>
</body>
</html>