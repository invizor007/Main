<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="div" encoding="windows-1251"/>
<xsl:template match="/">
<table>
<xsl:for-each select="tutorial/enimals/dogs/dog">
<xsl:sort order="ascending" select="number(dogWeight)"/>
<xsl:if test="dogWeight&lt;10">
<tr bgcolor="#8080FF">
<td><xsl:value-of select="dogName"/></td>
<td align="right"><xsl:value-of select="dogWeight"/> <xsl:value-of select="dogWeight/@caption"/></td>
<td><xsl:value-of select="dogColor"/></td>
</tr>
</xsl:if>
</xsl:for-each>
<xsl:for-each select="tutorial/enimals/dogs/dog">
<xsl:sort order="ascending" select="number(dogWeight)"/>
<xsl:if test="dogWeight&gt;15">
<tr bgcolor="#FF8080">
<td><xsl:value-of select="dogName"/></td>
<td align="right"><xsl:value-of select="dogWeight"/> <xsl:value-of select="dogWeight/@caption"/></td>
<td><xsl:value-of select="dogColor"/></td>
</tr>
</xsl:if>
</xsl:for-each>
</table>
</xsl:template>
</xsl:stylesheet>
