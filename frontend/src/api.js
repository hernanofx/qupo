const API_BASE = import.meta.env.VITE_API_URL || 'http://localhost:8000/api/v1';

async function postJson(path, body, token) {
  const res = await fetch(`${API_BASE}${path}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      ...(token ? { Authorization: `Bearer ${token}` } : {}),
    },
    body: JSON.stringify(body),
  });
  return res.json();
}

export async function registerMerchant(payload) {
  return postJson('/merchant/register', payload);
}

export async function login(payload) {
  return postJson('/merchant/login', payload);
}

export async function fetchMerchants() {
  const res = await fetch(`${API_BASE}/merchants`);
  return res.json();
}

export async function createMerchant(payload, token) {
  return postJson('/merchants', payload, token);
}

export async function createService(payload, token) {
  return postJson('/services', payload, token);
}

export async function createBooking(payload, token) {
  return postJson('/bookings', payload, token);
}

export async function createCheckout(payload, token) {
  return postJson('/payments/checkout', payload, token);
}

export default { registerMerchant, login, fetchMerchants, createMerchant, createService, createBooking, createCheckout };
