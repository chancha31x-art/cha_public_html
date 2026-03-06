<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9">
<xsl:output method="html" indent="yes" encoding="UTF-8"/>
<xsl:template match="/">
<html>
<head>
    <title>Sitemap — TH-SHOPs</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #f1f5f9; color: #1e293b; }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 40px; color: white;
        }
        .header h1 { font-size: 1.8rem; font-weight: 800; }
        .header p  { opacity: 0.8; margin-top: 5px; }
        .stats {
            display: flex; gap: 20px; flex-wrap: wrap;
            padding: 20px 40px; background: white;
            border-bottom: 1px solid #e2e8f0;
        }
        .stat-box {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            border-radius: 12px; padding: 12px 20px;
            font-size: 0.9rem; font-weight: 600; color: #374151;
        }
        .stat-box span { color: #667eea; font-size: 1.2rem; }
        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
        thead tr { background: linear-gradient(135deg, #667eea, #764ba2); color: white; }
        thead th { padding: 14px 18px; text-align: left; font-weight: 700; font-size: 0.88rem; }
        tbody tr:hover td { background: rgba(102,126,234,0.05); }
        tbody td { padding: 12px 18px; border-bottom: 1px solid #f1f5f9; font-size: 0.88rem; }
        tbody td a { color: #667eea; text-decoration: none; font-weight: 500; }
        tbody td a:hover { text-decoration: underline; }
        .badge { padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; }
        .badge-high   { background: #dcfce7; color: #166534; }
        .badge-medium { background: #fef9c3; color: #854d0e; }
        .badge-low    { background: #f1f5f9; color: #64748b; }
        .badge-article { background: #ede9fe; color: #5b21b6; }
        @media (max-width: 600px) {
            .header, .stats { padding: 20px; }
            thead th:nth-child(3), tbody td:nth-child(3) { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🗺️ XML Sitemap — TH-SHOPs</h1>
        <p>อัปเดตอัตโนมัติทุกวัน · <xsl:value-of select="count(sitemap:urlset/sitemap:url)"/> URLs ทั้งหมด</p>
    </div>
    <div class="stats">
        <div class="stat-box">URLs ทั้งหมด: <span><xsl:value-of select="count(sitemap:urlset/sitemap:url)"/></span></div>
        <div class="stat-box">Priority สูงสุด (1.00): <span><xsl:value-of select="count(sitemap:urlset/sitemap:url[sitemap:priority='1.00'])"/></span></div>
        <div class="stat-box">บทความ: <span><xsl:value-of select="count(sitemap:urlset/sitemap:url[contains(sitemap:loc,'/article/')])"/></span></div>
    </div>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>URL</th>
                    <th>อัปเดตล่าสุด</th>
                    <th>ความถี่</th>
                    <th>Priority</th>
                </tr>
            </thead>
            <tbody>
                <xsl:for-each select="sitemap:urlset/sitemap:url">
                    <xsl:sort select="sitemap:priority" order="descending" data-type="number"/>
                    <tr>
                        <td style="color:#94a3b8;"><xsl:value-of select="position()"/></td>
                        <td>
                            <a href="{sitemap:loc}" target="_blank"><xsl:value-of select="sitemap:loc"/></a>
                            <xsl:if test="contains(sitemap:loc,'/article/')">
                                <span class="badge badge-article" style="margin-left:8px;">บทความ</span>
                            </xsl:if>
                        </td>
                        <td><xsl:value-of select="sitemap:lastmod"/></td>
                        <td><xsl:value-of select="sitemap:changefreq"/></td>
                        <td>
                            <xsl:choose>
                                <xsl:when test="sitemap:priority >= 0.9">
                                    <span class="badge badge-high"><xsl:value-of select="sitemap:priority"/></span>
                                </xsl:when>
                                <xsl:when test="sitemap:priority >= 0.7">
                                    <span class="badge badge-medium"><xsl:value-of select="sitemap:priority"/></span>
                                </xsl:when>
                                <xsl:otherwise>
                                    <span class="badge badge-low"><xsl:value-of select="sitemap:priority"/></span>
                                </xsl:otherwise>
                            </xsl:choose>
                        </td>
                    </tr>
                </xsl:for-each>
            </tbody>
        </table>
    </div>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
