document.addEventListener('DOMContentLoaded', () => {
    const API_BASE_URL = 'http://localhost:8000/productos';
    const productForm = document.getElementById('product-form');
    const productsTable = document.getElementById('products-table').querySelector('tbody');
    const usdValue = document.getElementById('usd-value');
    const submitBtn = document.getElementById('submit-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const formTitle = document.getElementById('form-title');
    const productIdInput = document.getElementById('product-id');
    
    let currentUsdValue = 1;
    let editingProductId = null;
    
    async function loadUsdValue() {
        try {
            const response = await fetch(API_BASE_URL);
            const products = await response.json();
            if (products.length > 0 && products[0].precio_usd) {
                currentUsdValue = products[0].precio / products[0].precio_usd;
                usdValue.textContent = currentUsdValue.toFixed(2);
            }
        } catch (error) {
            console.error('Error al cargar el valor del dólar:', error);
            showMessage('Error al cargar el valor del dólar', 'error');
        }
    }
    
    async function loadProducts() {
        try {
            const response = await fetch(API_BASE_URL);
            if (!response.ok) throw new Error('Error al cargar productos');
            
            const products = await response.json();
            renderProducts(products);
        } catch (error) {
            console.error('Error:', error);
            showMessage('Error al cargar los productos', 'error');
        }
    }
    
    function renderProducts(products) {
        productsTable.innerHTML = '';
        
        if (products.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = '<td colspan="5">No hay productos disponibles</td>';
            productsTable.appendChild(row);
            return;
        }
        //aca carga productos en la tabla
        products.forEach(product => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${product.nombre}</td>
                <td>${product.descripcion || '-'}</td>
                <td>$${product.precio}</td>
                <td>$${product.precio_usd}</td>
                <td class="actions">
                    <button class="edit-btn" data-id="${product.id}">Editar</button>
                    <button class="delete-btn" data-id="${product.id}">Eliminar</button>
                </td>
            `;
            productsTable.appendChild(row);
        });
        
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', handleEdit);
        });
        
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', handleDelete);
        });
    }
    
    productForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const productData = {
            nombre: document.getElementById('nombre').value,
            descripcion: document.getElementById('descripcion').value,
            precio: parseFloat(document.getElementById('precio').value)
        };
        
        try {
            if (editingProductId) {
                const response = await fetch(`${API_BASE_URL}/${editingProductId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(productData)
                });
                
                if (!response.ok) throw new Error('Error al actualizar el producto');
                
                showMessage('Producto actualizado correctamente', 'success');
            } else {
                const response = await fetch(API_BASE_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(productData)
                });
                
                if (!response.ok) throw new Error('Error al crear el producto');
                
                showMessage('Producto creado correctamente', 'success');
            }
            
            resetForm();
            await loadProducts();
        } catch (error) {
            console.error('Error:', error);
            showMessage(error.message, 'error');
        }
    });
    
    async function handleEdit(e) {
        const productId = e.target.getAttribute('data-id');
        
        try {
            const response = await fetch(`${API_BASE_URL}/${productId}`);
            if (!response.ok) throw new Error('Error al cargar el producto');
            
            const product = await response.json();
            
            document.getElementById('nombre').value = product.nombre;
            document.getElementById('descripcion').value = product.descripcion || '';
            document.getElementById('precio').value = product.precio;
            productIdInput.value = product.id;
            
            editingProductId = product.id;
            formTitle.textContent = 'Editar Producto';
            submitBtn.textContent = 'Actualizar';
            cancelBtn.style.display = 'inline-block';
            
            document.querySelector('.form-section').scrollIntoView({ behavior: 'smooth' });
        } catch (error) {
            console.error('Error:', error);
            showMessage('Error al cargar el producto para editar', 'error');
        }
    }
    
    async function handleDelete(e) {
        const productId = e.target.getAttribute('data-id');
        
        if (!confirm('¿Estás seguro de que deseas eliminar este producto?')) {
            return;
        }
        
        try {
            const response = await fetch(`${API_BASE_URL}/${productId}`, {
                method: 'DELETE'
            });
            
            if (!response.ok) throw new Error('Error al eliminar el producto');
            
            showMessage('Producto eliminado correctamente', 'success');
            await loadProducts();
        } catch (error) {
            console.error('Error:', error);
            showMessage('Error al eliminar el producto', 'error');
        }
    }
    
    cancelBtn.addEventListener('click', resetForm);
    
    function resetForm() {
        productForm.reset();
        editingProductId = null;
        formTitle.textContent = 'Agregar Producto';
        submitBtn.textContent = 'Guardar';
        cancelBtn.style.display = 'none';
    }
    
    function showMessage(message, type) {
        const existingMessages = document.querySelectorAll('.message');
        existingMessages.forEach(msg => msg.remove());
        
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${type}`;
        messageDiv.textContent = message;
        
        const container = document.querySelector('.container');
        container.insertBefore(messageDiv, container.children[1]);
        
        setTimeout(() => {
            messageDiv.remove();
        }, 5000);
    }
    
    loadUsdValue();
    loadProducts();
});