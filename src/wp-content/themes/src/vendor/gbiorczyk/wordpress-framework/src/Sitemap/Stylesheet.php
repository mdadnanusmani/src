<?php

  namespace Framework\Sitemap;

  class Stylesheet {

    public function __construct() {

      add_action('pre_get_posts', [$this, 'showStylesheet']);

    }

    /* ---
      Functions
    --- */

      public function showStylesheet($query) {

        $type = get_query_var('wpf_sitemap_type');

        if (!$query->is_main_query() || ($type != 'stylesheet'))
          return;

        $content = '<?xml version="1.0" encoding="UTF-8"?>
          <xsl:stylesheet version="2.0"
            xmlns:html="http://www.w3.org/TR/REC-html40"
            xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
            xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
            xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
          <xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
          <xsl:template match="/">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
              <title>XML Sitemap</title>
              <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
              <style>
                #content {
                  width: calc(100% - 40px);
                  max-width: 800px;
                  margin: 30px auto;
                }
                #sitemap {
                  width: calc(100% + 8px);
                  margin: 0 -4px;
                  border-collapse: separate;
                  border-spacing: 4px;
                }
                #sitemap th,
                #sitemap td {
                  padding: 15px 20px;
                  text-align: left;
                  background-color: rgba(0, 0, 0, .05);
                }
                #sitemap th {
                  background-color: rgba(0, 0, 0, .2);
                }
                #sitemap th:nth-child(1),
                #sitemap td:nth-child(1) {
                  width: 70%;
                }
                #sitemap th:nth-child(1):last-child,
                #sitemap td:nth-child(1):last-child {
                  width: 100%;
                }
                #sitemap th:nth-child(2),
                #sitemap td:nth-child(2) {
                  width: 30%;
                }
                pre {
                  text-align: right;
                }
              </style>
            </head>
            <body>
            <div id="content">
              <h1>XML Sitemap</h1>
              <xsl:if test="count(sitemap:sitemapindex/sitemap:sitemap) &gt; 0">
                <p>This Sitemap contains <xsl:value-of select="count(sitemap:sitemapindex/sitemap:sitemap)"/> sitemap(s).</p>
                <table id="sitemap" cellpadding="3">
                  <thead>
                  <tr>
                    <th>URL</th>
                  </tr>
                  </thead>
                  <tbody>
                  <xsl:for-each select="sitemap:sitemapindex/sitemap:sitemap">
                    <xsl:variable name="sitemapURL">
                      <xsl:value-of select="sitemap:loc"/>
                    </xsl:variable>
                    <tr>
                      <td>
                        <a href="{$sitemapURL}"><xsl:value-of select="sitemap:loc"/></a>
                      </td>
                    </tr>
                  </xsl:for-each>
                  </tbody>
                </table>
                <pre>Generated by <strong>WordPress Framework</strong></pre>
              </xsl:if>
              <xsl:if test="count(sitemap:sitemapindex/sitemap:sitemap) &lt; 1">
                <p>This Sitemap contains <xsl:value-of select="count(sitemap:urlset/sitemap:url)"/> URL(s).</p>
                <table id="sitemap" cellpadding="3">
                  <thead>
                  <tr>
                    <th>URL</th>
                    <th>Last Mod.</th>
                  </tr>
                  </thead>
                  <tbody>
                    <xsl:for-each select="sitemap:urlset/sitemap:url">
                      <tr>
                        <td>
                          <xsl:variable name="itemURL">
                            <xsl:value-of select="sitemap:loc"/>
                          </xsl:variable>
                          <a href="{$itemURL}">
                            <xsl:value-of select="sitemap:loc"/>
                          </a>
                        </td>
                        <td>
                          <xsl:value-of select="concat(substring(sitemap:lastmod,0,11),concat(\' \', substring(sitemap:lastmod,12,5)),concat(\' \', substring(sitemap:lastmod,20,6)))"/>
                        </td>
                      </tr>
                    </xsl:for-each>
                  </tbody>
                </table>
                <pre>Generated by <strong>WordPress Framework</strong></pre>
              </xsl:if>
            </div>
            </body>
            </html>
          </xsl:template>
        </xsl:stylesheet>';

        echo $content;
        die();

      }

  }