'use strict';
const { chromium } = require('playwright');
const dns = require('node:dns').promises;
const net = require('node:net');
const fs = require('node:fs');
const url = process.argv[2];
const output = process.argv[3];
function publicIp(ip) {
  if (net.isIP(ip) !== 4) return false; // IPv6 disabled for capture
  const a = ip.split('.').map(Number);
  if (a[0] === 0 || a[0] === 10 || a[0] === 127 || a[0] >= 224 || a[0] === 169 && a[1] === 254 || a[0] === 172 && a[1] >= 16 && a[1] <= 31 || a[0] === 192 && a[1] === 168 || a[0] === 100 && a[1] >= 64 && a[1] <= 127 || a[0] === 192 && a[1] === 0 || a[0] === 198 && (a[1] === 18 || a[1] === 19) || a[0] === 198 && a[1] === 51 && a[2] === 100 || a[0] === 203 && a[1] === 0 && a[2] === 113) return false;
  return true;
}
async function allowed(raw) {
  let u;
  try { u = new URL(raw); } catch { return false; }
  if (!['http:', 'https:'].includes(u.protocol) || u.username || u.password || (u.port && !['80','443'].includes(u.port))) return false;
  if (net.isIP(u.hostname) || !u.hostname.includes('.') || /\.(local|localhost|internal)$/i.test(u.hostname)) return false;
  const ips = await dns.lookup(u.hostname, { all:true });
  return ips.length > 0 && ips.every(v => publicIp(v.address));
}
(async () => {
  if (!url || !output || !(await allowed(url))) throw new Error('Only public HTTP(S) websites are supported.');
  const browser = await chromium.launch({headless:true});
  try {
    const context = await browser.newContext({viewport:{width:1440,height:900}, deviceScaleFactor:1, serviceWorkers:'block', acceptDownloads:false});
    const page = await context.newPage();
    await page.route('**/*', async route => {
      try { if (await allowed(route.request().url())) await route.continue(); else await route.abort(); }
      catch { await route.abort(); }
    });
    await page.goto(url, {waitUntil:'domcontentloaded', timeout:25000});
    await page.waitForTimeout(2500);
    await page.screenshot({path:output,fullPage:true, animations:'disabled', timeout:20000});
    if (fs.statSync(output).size > 15*1024*1024) throw new Error('Screenshot too large.');
  } finally { await browser.close(); }
})().catch(e => { try { if(output) fs.unlinkSync(output); } catch {} console.error(e.message); process.exit(1); });
