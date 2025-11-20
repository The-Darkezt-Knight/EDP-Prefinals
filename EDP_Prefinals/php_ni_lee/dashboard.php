<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Analytics Chart — Dashboard</title>
  <style>
    :root{
      --bg:#0a0f1c;
      --bg-1:#0b1020;
      --bg-2:#0c1528;
      --card:#0b1220;
      --muted:#9fb2c9;
      --accent1:#60a5fa;
      --accent2:#7c3aed;
      --accent3:#f472b6;
      --accent4:#22d3ee;
      --glass: rgba(255,255,255,0.05);
      --glass-2: rgba(255,255,255,0.03);
      --success:#34d399;
      --danger:#fb7185;
      --radius:16px;
      --fw-700:700;
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0;
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
      background:
        radial-gradient(1000px 480px at 12% 8%, rgba(124,58,237,0.18), transparent),
        radial-gradient(900px 420px at 88% 92%, rgba(96,165,250,0.12), transparent),
        radial-gradient(800px 380px at 40% 30%, rgba(34,211,238,0.10), transparent),
        linear-gradient(180deg, var(--bg-1), var(--bg-2));
      color: #e6eef8;
      -webkit-font-smoothing:antialiased;
      padding:28px;
      animation: bgFloat 18s ease-in-out infinite alternate;
    }

    @keyframes bgFloat {
      0% { background-position: 0px 0px, 0px 0px, 0px 0px, 0 0; }
      100% { background-position: 20px -30px, -30px 20px, 10px 30px, 0 0; }
    }

    .wrap{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1fr 360px;gap:20px;align-items:start}

    header{display:flex;align-items:center;gap:16px;margin-bottom:14px}
    .logo{width:56px;height:56px;border-radius:14px;background:conic-gradient(from 220deg at 50% 50%, var(--accent1), var(--accent2), var(--accent3), var(--accent4), var(--accent1));display:flex;align-items:center;justify-content:center;font-weight:800;box-shadow:0 10px 28px rgba(16,24,40,.5); border:1px solid rgba(255,255,255,0.08)}
    .title h1{margin:0;font-size:20px}
    .title p{margin:0;color:var(--muted);font-size:13px}

    .card{
      background:
        linear-gradient(180deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02)) border-box,
        linear-gradient(180deg, var(--card), rgba(255,255,255,0.02)) padding-box;
      border:1px solid transparent;
      border-radius:var(--radius);
      padding:18px;
      box-shadow:0 12px 32px rgba(2,6,23,.55);
      backdrop-filter: blur(8px) saturate(120%);
    }

    .overview{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:16px}
    .kpi{display:flex;flex-direction:column;gap:8px}
    .kpi small{color:var(--muted);font-size:12px}
    .kpi .value{font-size:20px;font-weight:700}
    .kpi .delta{font-size:12px;color:var(--success);background:linear-gradient(90deg,rgba(52,211,153,0.08),transparent);padding:6px 8px;border-radius:999px;display:inline-block}

    .main{display:grid;grid-template-columns:1fr;gap:14px}

    /* Chart area */
    .chart-wrap{display:flex;gap:14px}
    .chart-card{flex:1;min-height:340px;padding:16px}
    .chart-actions{display:flex;gap:10px;align-items:center;margin-bottom:12px}
    .btn{
      background:
        linear-gradient(180deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02)) padding-box,
        linear-gradient(90deg, rgba(96,165,250,.35), rgba(124,58,237,.35)) border-box;
      border:1px solid transparent;
      padding:8px 12px;border-radius:12px;cursor:pointer;color:var(--muted);font-weight:700;letter-spacing:.2px;transition:transform .2s ease, box-shadow .2s ease, color .2s ease;
    }
    .btn:hover{color:#eaf2ff; box-shadow:0 8px 20px rgba(124,58,237,0.18); transform:translateY(-1px)}
    .btn.active{background:linear-gradient(90deg,var(--accent1),var(--accent2));color:white;box-shadow:0 10px 22px rgba(124,58,237,0.25);}

    /* side panel */
    .side{display:flex;flex-direction:column;gap:14px}
    .small{font-size:13px;color:var(--muted)}

    /* chart SVG styles */
    .chart-svg{width:100%;height:270px;display:block}
    .grid-line{stroke:rgba(255,255,255,0.03);stroke-width:1}
    .axis-label{fill:var(--muted);font-size:12px}

    /* tooltip container (injected) */
    .tip{pointer-events:none;font-size:12px;background:linear-gradient(180deg,#0b1220,rgba(11,18,32,0.7));padding:10px;border-radius:10px;border:1px solid rgba(255,255,255,0.06);box-shadow:0 14px 28px rgba(2,6,23,0.6); transform:translateY(6px); opacity:0; animation: tipIn .15s ease forwards}
    @keyframes tipIn { to { transform:translateY(0); opacity:1 } }

    /* legend */
    .legend{display:flex;gap:12px;align-items:center}
    .legend .item{display:flex;gap:8px;align-items:center;font-size:13px;color:var(--muted); background:var(--glass-2); border:1px solid rgba(255,255,255,0.06); padding:6px 10px; border-radius:999px}
    .dot{width:10px;height:10px;border-radius:3px; box-shadow:0 0 0 3px rgba(124,58,237,0.14) inset}

    /* table */
    table{width:100%;border-collapse:collapse}
    th,td{padding:8px 6px;text-align:left;font-size:13px}
    th{color:var(--muted);font-weight:600;font-size:12px}
    tr{border-bottom:1px dashed rgba(255,255,255,0.03)}

    /* small sparkline */
    .spark{width:100%;height:48px}

    /* responsive */
    @media (max-width:980px){
      .wrap{grid-template-columns:1fr;}
      .overview{grid-template-columns:1fr 1fr}
      .chart-wrap{flex-direction:column}
    }
  </style>
</head>
<body>
  <div class="wrap">
    <div>
      <header>
        <div class="logo">AN</div>
        <div class="title">
          <h1>Analytics Dashboard</h1>
          <p>Interactive charts — Web-only (pure HTML/CSS/JS)</p>
        </div>
      </header>

      <div class="card overview">
        <div class="kpi">
          <small>Active Users</small>
          <div class="value" id="kpi-users">12,348</div>
          <div class="delta" id="kpi-users-delta">+6.2% vs last week</div>
        </div>
        <div class="kpi">
          <small>Conversion Rate</small>
          <div class="value" id="kpi-cr">3.8%</div>
          <div class="delta" id="kpi-cr-delta">+0.6%</div>
        </div>
        <div class="kpi">
          <small>Revenue</small>
          <div class="value" id="kpi-rev">₹72,954</div>
          <div class="delta" id="kpi-rev-delta" style="color:var(--danger);">-2.1%</div>
        </div>
      </div>

      <div class="main">
        <div class="card chart-card">
          <div class="chart-actions">
            <div class="legend">
              <div class="item"><span class="dot" style="background:linear-gradient(90deg,var(--accent1),var(--accent2))"></span> Sessions</div>
              <div class="item"><span class="dot" style="background:linear-gradient(90deg,var(--success),#10b981)"></span> Conversions</div>
            </div>
            <div style="flex:1"></div>
            <button class="btn" data-period="7">7d</button>
            <button class="btn active" data-period="30">30d</button>
            <button class="btn" data-period="90">90d</button>
          </div>

          <!-- SVG chart (line + area) -->
          <svg class="chart-svg" viewBox="0 0 900 300" preserveAspectRatio="none" id="mainChart">
            <!-- grid lines inserted by JS -->
          </svg>

          <div style="display:flex;justify-content:space-between;margin-top:12px;color:var(--muted)">
            <div id="chart-stats">Showing last 30 days</div>
            <div style="display:flex;gap:12px;align-items:center">
              <div class="small">Avg. session: <strong id="avgSession">3m 12s</strong></div>
              <div class="small">Bounce: <strong id="bounce">42%</strong></div>
            </div>
          </div>
        </div>

        <div class="card" style="display:flex;gap:14px;align-items:flex-start;">
          <div style="flex:1;">
            <small style="color:var(--muted)">Revenue Breakdown</small>
            <svg viewBox="0 0 200 200" style="width:150px;height:150px;display:block;margin-top:6px" id="donut"></svg>
          </div>
          <div style="width:260px;">
            <small style="color:var(--muted)">Top campaigns</small>
            <table style="margin-top:8px">
              <thead><tr><th>Campaign</th><th>Revenue</th></tr></thead>
              <tbody id="campaignsTable">
                <!-- rows from JS -->
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>

    <aside class="side">
      <div class="card">
        <small class="small">Realtime</small>
        <div style="display:flex;align-items:center;gap:12px;margin-top:10px">
          <div style="font-size:28px;font-weight:800">564</div>
          <div style="color:var(--muted)">users currently online</div>
        </div>
        <div style="margin-top:12px"><canvas class="spark" id="spark1"></canvas></div>
      </div>

      <div class="card">
        <small class="small">Traffic Sources</small>
        <div style="display:flex;flex-direction:column;gap:8px;margin-top:10px">
          <div style="display:flex;justify-content:space-between"><div style="color:var(--muted)">Organic</div><div>58%</div></div>
          <div style="display:flex;justify-content:space-between"><div style="color:var(--muted)">Referral</div><div>19%</div></div>
          <div style="display:flex;justify-content:space-between"><div style="color:var(--muted)">Social</div><div>13%</div></div>
          <div style="display:flex;justify-content:space-between"><div style="color:var(--muted)">Paid</div><div>10%</div></div>
        </div>
      </div>

      <div class="card">
        <small class="small">Latest Events</small>
        <ul style="margin-top:8px;padding-left:18px;color:var(--muted)">
          <li>User signup (premium) — 8m ago</li>
          <li>Checkout failed — 21m ago</li>
          <li>Campaign A launched — 2h ago</li>
        </ul>
      </div>
    </aside>

  </div>

  <script>
    // Sample data generator and chart drawing (pure JS + SVG + Canvas sparkline)
    (function(){
      const dayLabels = (n)=>Array.from({length:n}).map((_,i)=>{const d=new Date();d.setDate(d.getDate()- (n-1-i));return (d.getMonth()+1)+"/"+d.getDate()});

      function genData(n){
        const labels = dayLabels(n);
        let base=8000;
        const sessions = labels.map((_,i)=>Math.round(base + (Math.sin(i/6)*600) + Math.random()*900 - 300));
        const conversions = sessions.map(s=>Math.round(s*(0.02 + Math.random()*0.02)));
        return {labels,sessions,conversions};
      }

      const periods = {7: genData(7),30: genData(30),90: genData(90)};
      let currentPeriod = 30;

      // DOM references
      const svg = document.getElementById('mainChart');
      const buttons = Array.from(document.querySelectorAll('.btn'));
      const chartStats = document.getElementById('chart-stats');

      buttons.forEach(b=>b.addEventListener('click',()=>{
        buttons.forEach(x=>x.classList.remove('active'));
        b.classList.add('active');
        const p = +b.dataset.period;
        currentPeriod = p;
        drawChart(periods[p]);
      }));

      function clearSvg(){while(svg.firstChild)svg.removeChild(svg.firstChild)}

      function drawChart(data){
        clearSvg();
        const w = 900, h = 300, pad = 48;
        svg.setAttribute('viewBox',`0 0 ${w} ${h}`);

        // compute scales
        const maxS = Math.max(...data.sessions) * 1.12;
        const minS = Math.min(...data.sessions) * 0.9;
        const xStep = (w-2*pad)/(data.labels.length-1||1);

        function x(i){return pad + i*xStep}
        function yS(v){return h - pad - ( (v - minS)/(maxS-minS) )*(h-2*pad)}

        // grid lines
        const lines = 4;
        for(let i=0;i<=lines;i++){
          const yy = pad + i*( (h-2*pad)/lines );
          const l = document.createElementNS('http://www.w3.org/2000/svg','line');
          l.setAttribute('x1',pad); l.setAttribute('x2',w-pad); l.setAttribute('y1',yy); l.setAttribute('y2',yy);
          l.setAttribute('class','grid-line'); svg.appendChild(l);
        }

        // area path for sessions
        const area = document.createElementNS('http://www.w3.org/2000/svg','path');
        let dpath = '';
        data.sessions.forEach((s,i)=>{
          const xx = x(i); const yy = yS(s);
          dpath += (i===0?`M ${xx} ${yy}`:` L ${xx} ${yy}`);
        });
        // close area
        dpath += ` L ${w-pad} ${h-pad} L ${pad} ${h-pad} Z`;
        area.setAttribute('d',dpath);
        area.setAttribute('fill','url(#gradArea)');
        area.setAttribute('opacity','0.28');
        svg.appendChild(area);

        // define gradient
        const defs = document.createElementNS('http://www.w3.org/2000/svg','defs');
        defs.innerHTML = `
          <linearGradient id="gradArea" x1="0" x2="0" y1="0" y2="1">
            <stop offset="0%" stop-color="#60a5fa" stop-opacity="0.9" />
            <stop offset="100%" stop-color="#7c3aed" stop-opacity="0.1" />
          </linearGradient>
          <linearGradient id="gradLine" x1="0" x2="1">
            <stop offset="0%" stop-color="#60a5fa" />
            <stop offset="100%" stop-color="#7c3aed" />
          </linearGradient>
          <filter id="glow">
            <feDropShadow dx="0" dy="0" stdDeviation="6" flood-color="#7c3aed" flood-opacity="0.6" />
          </filter>
          <filter id="glowSoft">
            <feDropShadow dx="0" dy="4" stdDeviation="8" flood-color="#60a5fa" flood-opacity="0.16" />
          </filter>
        `;
        svg.appendChild(defs);

        // line path (sessions)
        const line = document.createElementNS('http://www.w3.org/2000/svg','path');
        let lpath='';
        data.sessions.forEach((s,i)=>{const xx=x(i), yy=yS(s); lpath+=(i===0?`M ${xx} ${yy}`:` L ${xx} ${yy}`)});
        line.setAttribute('d',lpath);
        line.setAttribute('fill','none'); line.setAttribute('stroke','url(#gradLine)'); line.setAttribute('stroke-width','3'); line.setAttribute('stroke-linecap','round'); line.setAttribute('filter','url(#glow)');
        svg.appendChild(line);

        // conversions (smaller line)
        const maxC = Math.max(...data.conversions)*1.2;
        const minC = 0;
        const yC = v=> h - pad - (v/maxC)*(h-2*pad);
        const convPath = document.createElementNS('http://www.w3.org/2000/svg','path');
        let cpath='';
        data.conversions.forEach((c,i)=>{const xx=x(i), yy=yC(c); cpath+=(i===0?`M ${xx} ${yy}`:` L ${xx} ${yy}`)});
        convPath.setAttribute('d',cpath); convPath.setAttribute('fill','none'); convPath.setAttribute('stroke','#10b981'); convPath.setAttribute('stroke-width','2'); convPath.setAttribute('stroke-dasharray','6 4'); convPath.setAttribute('opacity','0.9');
        svg.appendChild(convPath);

        // points + tooltips
        const tooltip = document.createElement('div');
        // We'll create a foreignObject overlay for basic tooltips
        const fo = document.createElementNS('http://www.w3.org/2000/svg','foreignObject');
        fo.setAttribute('x',0);fo.setAttribute('y',0);fo.setAttribute('width',w);fo.setAttribute('height',h);
        const foDiv = document.createElement('div');
        foDiv.setAttribute('xmlns','http://www.w3.org/1999/xhtml');
        foDiv.style.pointerEvents='none';
        fo.appendChild(foDiv);

        data.sessions.forEach((s,i)=>{
          const cx = x(i), cy = yS(s);
          const circ = document.createElementNS('http://www.w3.org/2000/svg','circle');
          circ.setAttribute('cx',cx); circ.setAttribute('cy',cy); circ.setAttribute('r',4.5); circ.setAttribute('fill','#fff'); circ.setAttribute('stroke','url(#gradLine)'); circ.setAttribute('stroke-width','2'); circ.setAttribute('opacity',0.98); circ.setAttribute('filter','url(#glowSoft)');
          circ.style.cursor='pointer';
          svg.appendChild(circ);

          // attach pointer events
          circ.addEventListener('mouseenter', (ev)=>{
            // create tooltip element
            foDiv.innerHTML = `<div class="tip">`+
                              `<div style=\"font-weight:700;margin-bottom:6px\">${data.labels[i]}</div>`+
                              `<div style=\"color:var(--muted)\">Sessions: <strong>${s}</strong></div>`+
                              `<div style=\"color:var(--muted)\">Conversions: <strong>${data.conversions[i]}</strong></div>`+
                              `</div>`;
            // position
            const px = cx + 6; const py = cy - 36;
            foDiv.style.position='absolute'; foDiv.style.left = px+'px'; foDiv.style.top = py+'px';
          });
          circ.addEventListener('mouseleave', ()=>{foDiv.innerHTML=''});
        });

        svg.appendChild(fo);

        // x-axis labels: show a few
        const showEvery = Math.max(1, Math.floor(data.labels.length/6));
        data.labels.forEach((lab,i)=>{
          if(i%showEvery===0 || i===data.labels.length-1){
            const tx = document.createElementNS('http://www.w3.org/2000/svg','text');
            tx.setAttribute('x', x(i)); tx.setAttribute('y', h-12); tx.setAttribute('text-anchor','middle'); tx.setAttribute('class','axis-label'); tx.textContent = lab;
            svg.appendChild(tx);
          }
        });

        // update KPI quick stats
        const totalSessions = data.sessions.reduce((a,b)=>a+b,0);
        const totalConv = data.conversions.reduce((a,b)=>a+b,0);
        document.getElementById('kpi-users').textContent = (+totalSessions).toLocaleString();
        document.getElementById('kpi-cr').textContent = ((totalConv/totalSessions)*100).toFixed(2) + '%';
        document.getElementById('kpi-rev').textContent = '₹' + Math.round(totalConv*120).toLocaleString();
        chartStats.textContent = `Showing last ${data.labels.length} days`;
      }

      // small donut chart
      function drawDonut(){
        const svgD = document.getElementById('donut');
        svgD.innerHTML='';
        const w=200,h=200,r=70,cx=100,cy=100;
        const parts = [58,19,13,10];
        const colors = ['#60a5fa','#7c3aed','#34d399','#fb7185'];
        const total = parts.reduce((a,b)=>a+b,0);
        let angle= -90;
        parts.forEach((p,i)=>{
          const a = (p/total)*360;
          const large = a>180?1:0;
          const start = angle; const end = angle + a;
          const x1 = cx + r*Math.cos(start*Math.PI/180);
          const y1 = cy + r*Math.sin(start*Math.PI/180);
          const x2 = cx + r*Math.cos(end*Math.PI/180);
          const y2 = cy + r*Math.sin(end*Math.PI/180);
          const d = `M ${cx} ${cy} L ${x1} ${y1} A ${r} ${r} 0 ${large} 1 ${x2} ${y2} Z`;
          const path = document.createElementNS('http://www.w3.org/2000/svg','path');
          path.setAttribute('d',d); path.setAttribute('fill',colors[i]); path.setAttribute('opacity',0.95);
          svgD.appendChild(path);
          angle += a;
        });
        // center cutout
        const cut = document.createElementNS('http://www.w3.org/2000/svg','circle');
        cut.setAttribute('cx',cx); cut.setAttribute('cy',cy); cut.setAttribute('r',40); cut.setAttribute('fill','rgba(11,18,32,0.92)'); svgD.appendChild(cut);
        const lbl = document.createElementNS('http://www.w3.org/2000/svg','text'); lbl.setAttribute('x',cx); lbl.setAttribute('y',cy); lbl.setAttribute('text-anchor','middle'); lbl.setAttribute('dominant-baseline','middle'); lbl.setAttribute('font-size','12'); lbl.setAttribute('fill','#e6eef8'); lbl.textContent='₹' + Math.round(parts[0]/100*120*1000).toLocaleString(); svgD.appendChild(lbl);

        // table rows
        const campaigns = [
          ['Search Ads','₹28,320'],
          ['Organic','₹19,240'],
          ['Affiliate','₹13,120'],
          ['Social','₹12,274']
        ];
        const tbody = document.getElementById('campaignsTable'); tbody.innerHTML='';
        campaigns.forEach(r=>{const tr=document.createElement('tr');tr.innerHTML=`<td style="color:var(--muted)">${r[0]}</td><td><strong>${r[1]}</strong></td>`;tbody.appendChild(tr)});
      }

      // sparkline canvas
      function drawSpark(){
        const c = document.getElementById('spark1'); c.width = c.clientWidth*devicePixelRatio; c.height = c.clientHeight*devicePixelRatio; const ctx = c.getContext('2d'); ctx.scale(devicePixelRatio,devicePixelRatio);
        const w = c.clientWidth; const h = c.clientHeight;
        const vals = Array.from({length:30},(_,i)=> 200 + Math.sin(i/3)*40 + Math.random()*40 );
        const max = Math.max(...vals), min=Math.min(...vals);
        ctx.lineWidth=2; ctx.beginPath(); vals.forEach((v,i)=>{const x = i*(w/(vals.length-1)); const y = h - ( (v-min)/(max-min) * h); if(i===0) ctx.moveTo(x,y); else ctx.lineTo(x,y)}); ctx.strokeStyle='#60a5fa'; ctx.stroke();
      }

      // init
      drawChart(periods[currentPeriod]); drawDonut(); drawSpark();

      // small auto-update simulation for realtime users
      setInterval(()=>{
        const val = 400 + Math.round(Math.random()*600);
        document.querySelector('.side .card div[style]') && (document.querySelector('.side .card div[style]').textContent = val);
      },4000);

    })();
  </script>
</body>
</html>