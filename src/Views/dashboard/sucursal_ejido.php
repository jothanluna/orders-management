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
      <div class="bg-white rounded-lg shadow overflow-x-auto">
          <table class="min-w-full">
              <thead class="bg-gray-50">
                  <tr>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Órdenes</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Burritos</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bebidas</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paga con</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Método Pago</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cambio</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Envío</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Repartidor</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dinero Recibido</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre Repartidor</th>
                  </tr>
              </thead>
              <tbody id="orders-table"></tbody>
              <tfoot id="orders-totals" class="bg-gray-50 font-bold"></tfoot>
          </table>
      </div>
  </main>

  <script>
  let currentData = [];
  let currentDay = 0;

  async function loadData(day = 0) {
        try {
            const response = await fetch(`${BASE_URL}/../src/Controllers/DashboardController.php?action=stats&sucursal=ejido&periodo=dia&day=${day}`);
            const data = await response.json();

            if (data.success) {
                currentData = Object.entries(data.data).map(([key, value]) => ({
                    metodo_pago: key,
                    monto: parseFloat(value)
                }));

                updateTotals(data.data);
                updateTabs(day);

                const ordersResponse = await fetch(`${BASE_URL}/../src/Controllers/DashboardController.php?action=orders&sucursal=ejido&day=${day}`);
                const ordersData = await ordersResponse.json();
                if (ordersData.success) {
                    currentData = ordersData.data;
                    updateTable(currentData);
                }
            }
        } catch (error) {
            console.error('Error:', error);
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
            // Actualizar los cuadros superiores con los nuevos totales
            updateTotals(result.stats);

            // Recargar la tabla para reflejar la nueva orden
            loadData(currentDay);
        } else {
            console.error('Error al agregar la orden:', result.error);
        }
    } catch (error) {
        console.error('Error al agregar la orden:', error);
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
      
      tbody.innerHTML = orders.map(order => 
          `<tr class="hover:bg-gray-50">
              <td class="px-6 py-4" contenteditable="true" onblur="updateField(${order.id}, 'nombre', this)" data-original="${order.nombre}">${order.nombre}</td>
              <td class="px-6 py-4" contenteditable="true" onblur="updateField(${order.id}, 'ordenes', this)" data-original="${order.ordenes || 0}">${order.ordenes || 0}</td>
              <td class="px-6 py-4" contenteditable="true" onblur="updateField(${order.id}, 'burritos', this)" data-original="${order.burritos || 0}">${order.burritos || 0}</td>
              <td class="px-6 py-4" contenteditable="true" onblur="updateField(${order.id}, 'bebidas', this)" data-original="${order.bebidas || 0}">${order.bebidas || 0}</td>
              <td class="px-6 py-4" contenteditable="true" onblur="updateField(${order.id}, 'total', this)" data-original="${order.total || 0}">$${parseFloat(order.total || 0).toFixed(2)}</td>
              <td class="px-6 py-4" contenteditable="true" onblur="updateField(${order.id}, 'paga_con', this)" data-original="${order.paga_con || 0}">$${parseFloat(order.paga_con || 0).toFixed(2)}</td>
              <td class="px-6 py-4">
                  <select class="w-full bg-transparent" onchange="updateField(${order.id}, 'metodo_pago', this)">
                      <option value="Efectivo" ${order.metodo_pago === 'Efectivo' ? 'selected' : ''}>Efectivo</option>
                      <option value="Transferencia" ${order.metodo_pago === 'Transferencia' ? 'selected' : ''}>Transferencia</option>
                      <option value="Tarjeta" ${order.metodo_pago === 'Tarjeta' ? 'selected' : ''}>Tarjeta</option>
                  </select>
              </td>
              <td class="px-6 py-4">$${parseFloat(order.cambio || 0).toFixed(2)}</td>
              <td class="px-6 py-4" contenteditable="true" onblur="updateField(${order.id}, 'envio', this)" data-original="${order.envio || 0}">$${parseFloat(order.envio || 0).toFixed(2)}</td>
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
                        onchange="updateField(${order.id}, 'dinero_recibido', this)"
                        data-original="${order.dinero_recibido || 0}"
                    >
                </td>
              <td class="px-6 py-4" contenteditable="true" 
                  onblur="updateField(${order.id}, 'nombre_repartidor', this)" 
                  data-original="${order.nombre_repartidor || ''}">${order.nombre_repartidor || ''}</td>
            <td class="px-6 py-4">
                <button onclick="deleteOrder(${order.id})" 
                        class="text-red-600 hover:text-red-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            </td>
          </tr>`
      ).join('');

      addKeyListeners();
      const totals = calculateTotals(orders);
      updateFooter(totals, tfoot);
  }

  function addKeyListeners() {
      document.querySelectorAll('[contenteditable="true"]').forEach(element => {
          element.addEventListener('keydown', function(e) {
              if (e.key === 'Enter') {
                  e.preventDefault();
                  this.blur();
              }
          });
      });
  }

  async function updateField(id, field, element) {
    let value;
    
    if (field === 'dinero_recibido') {
        value = element.checked ? 1 : 0;
        console.log('Checkbox value:', value); // Para debug
    } else if (element.tagName === 'SELECT') {
        value = element.value;
    } else {
        value = element.innerText.replace(/[$,]/g, '').trim();
    }

    console.log('Enviando:', { id, field, value }); // Para debug

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
                sucursal: 'ejido',
                day: currentDay
            })
        });

        const data = await response.json();
            if (data.success) {
                if (['total', 'paga_con', 'metodo_pago', 'envio', 'ordenes', 'burritos', 'bebidas'].includes(field)) {
                    loadData(currentDay);
                }
            } else {
                console.error('Error:', data.error);
                // ... resto del código de manejo de errores
            }

        if (data.success) {
            element.dataset.original = value;
            // No recargar todos los datos para el checkbox
            if (!['dinero_recibido'].includes(field)) {
                loadData(currentDay);
            }
        } else {
            console.error('Error:', data.error);
            if (field === 'dinero_recibido') {
                element.checked = element.dataset.original === '1';
            } else if (element.tagName === 'SELECT') {
                element.value = element.dataset.original;
            } else {
                element.innerText = element.dataset.original;
            }
        }
    } catch (error) {
        console.error('Error:', error);
        // Restaurar estado original
        if (field === 'dinero_recibido') {
            element.checked = element.dataset.original === '1';
        }
    }
}

  function calculateTotals(orders) {
      return orders.reduce((acc, order) => ({
          ordenes: acc.ordenes + parseInt(order.ordenes || 0),
          burritos: acc.burritos + parseInt(order.burritos || 0),
          bebidas: acc.bebidas + parseInt(order.bebidas || 0),
          total: acc.total + parseFloat(order.total || 0),
          paga_con: acc.paga_con + parseFloat(order.paga_con || 0),
          cambio: acc.cambio + parseFloat(order.cambio || 0),
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
              <td class="px-6 py-4">$${totals.paga_con.toFixed(2)}</td>
              <td class="px-6 py-4"></td>
              <td class="px-6 py-4">$${totals.cambio.toFixed(2)}</td>
              <td class="px-6 py-4">$${totals.envio.toFixed(2)}</td>
              <td colspan="3"></td>
          </tr>
      `;
  }

  function updateTotals(data) {
       document.getElementById('efectivo-total').textContent = `$${parseFloat(data.efectivo_neto || 0).toFixed(2)}`;
       document.getElementById('transferencia-total').textContent = `$${parseFloat(data.stats.find(d => d.metodo_pago === 'Transferencia')?.monto || 0).toFixed(2)}`;
       document.getElementById('tarjeta-total').textContent = `$${parseFloat(data.stats.find(d => d.metodo_pago === 'Tarjeta')?.monto || 0).toFixed(2)}`;
       document.getElementById('envios-total').textContent = `$${parseFloat(data.envios || 0).toFixed(2)}`;
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
       const filteredData = method
           ? currentData.filter(order => order.metodo_pago?.trim().toLowerCase() === method.trim().toLowerCase())
           : currentData;
       updateTable(filteredData);
   }

  loadData(0);
  </script>
</body>
</html>