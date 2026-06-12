// Service Worker for Push Notifications
const CACHE_NAME = 'ramadan-prayer-times-v1';

self.addEventListener('install', (event) => {
    console.log('✅ Service Worker installing...');
    self.skipWaiting();
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll([
                '/',
                '/css/styles.css',
                '/js/scripts.js'
            ]);
        })
    );
});

self.addEventListener('activate', (event) => {
    console.log('✅ Service Worker activating...');
    event.waitUntil(clients.claim());
});

// Handle push notifications
self.addEventListener('push', (event) => {
    console.log('📨 Push notification received', event);
    
    let data = {};
    
    if (event.data) {
        try {
            data = event.data.json();
        } catch (e) {
            data = {
                title: 'Ramadan Prayer Time',
                body: event.data.text(),
                icon: '/icon.png',
                badge: '/badge.png'
            };
        }
    }
    
    const options = {
        body: data.body || 'It\'s time for prayer!',
        icon: data.icon || 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="%234a90e2" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>',
        badge: data.badge || 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="%234a90e2" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>',
        vibrate: [200, 100, 200],
        tag: data.tag || 'ramadan-alarm',
        renotify: true,
        requireInteraction: true,
        data: data,
        actions: [
            { action: 'open', title: 'Open App' },
            { action: 'close', title: 'Close' }
        ],
        timestamp: Date.now()
    };
    
    event.waitUntil(
        self.registration.showNotification(
            data.title || '🌙 Ramadan Prayer Time',
            options
        )
    );
});

// Handle notification click
self.addEventListener('notificationclick', (event) => {
    console.log('🔔 Notification clicked', event);
    
    event.notification.close();
    
    if (event.action === 'close') {
        return;
    }
    
    // Open or focus the app
    const urlToOpen = new URL('/', self.location.origin).href;
    
    const promiseChain = clients.matchAll({
        type: 'window',
        includeUncontrolled: true
    }).then((windowClients) => {
        let matchingClient = null;
        
        for (let i = 0; i < windowClients.length; i++) {
            const windowClient = windowClients[i];
            if (windowClient.url === urlToOpen) {
                matchingClient = windowClient;
                break;
            }
        }
        
        if (matchingClient) {
            return matchingClient.focus();
        } else {
            return clients.openWindow(urlToOpen);
        }
    });
    
    event.waitUntil(promiseChain);
});

// Handle messages from the main page
self.addEventListener('message', (event) => {
    if (event.data && event.data.type === 'SHOW_NOTIFICATION') {
        self.registration.showNotification(event.data.title, {
            body: event.data.body,
            icon: event.data.icon || 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="%234a90e2" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>',
            badge: event.data.badge || 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="%234a90e2" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>',
            vibrate: [200, 100, 200],
            tag: event.data.tag || 'ramadan-alarm',
            renotify: true,
            requireInteraction: true,
            timestamp: Date.now()
        });
    }
});

// Handle periodic sync for checking alarms
self.addEventListener('periodicsync', (event) => {
    if (event.tag === 'check-alarms') {
        event.waitUntil(checkAlarms());
    }
});

async function checkAlarms() {
    // This would typically fetch from your server
    // But for demo, we'll check IndexedDB or cache
    const cache = await caches.open('alarms-cache');
    const response = await cache.match('/scheduled-alarms');
    
    if (response) {
        const alarms = await response.json();
        const now = Date.now();
        
        alarms.forEach(alarm => {
            const alarmTime = new Date(alarm.alarmTime).getTime();
            if (alarmTime <= now && alarmTime > now - 60000) {
                self.registration.showNotification(
                    `🌙 ${alarm.prayerType} Time Now`,
                    {
                        body: `${alarm.city}: ${alarm.time12}`,
                        icon: 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="%234a90e2" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>',
                        badge: 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="%234a90e2" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>',
                        tag: `alarm-${alarm.id}`,
                        renotify: true,
                        requireInteraction: true
                    }
                );
            }
        });
    }
}