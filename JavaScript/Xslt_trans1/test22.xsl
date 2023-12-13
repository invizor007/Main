<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet
  version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" encoding="windows-1251"/>
  <xsl:param name="current" select="''"/>
  <xsl:key name="cat" match="category" use="generate-id(.)"/>
  <xsl:variable name="category" select="key('cat',$current)"/>
  <xsl:variable name="path"
    select="$category/ancestor-or-self::category"/>
  <xsl:template match="catalog">
    <xsl:apply-templates select="category"/>
  </xsl:template>

  <xsl:template match="category">
    <xsl:param name="indent"/>
    <xsl:value-of select="$indent"/>
    <a href="javascript:expand('{generate-id(.)}')">
      <img height="11" width="11" border="0">
        <xsl:choose>
          <xsl:when test="not(*)">
            <xsl:attribute name="src">images/dot.gif</xsl:attribute>
          </xsl:when>
          <xsl:when test="count(.|$path)=count($path)">
            <xsl:attribute name="src">images/minus.gif</xsl:attribute>
          </xsl:when>
          <xsl:otherwise>
            <xsl:attribute name="src">images/plus.gif</xsl:attribute>
          </xsl:otherwise>
        </xsl:choose>
      </img>

      <xsl:text>&#xA0;</xsl:text>
      <xsl:value-of select="@title"/>
    </a>
    <br/><xsl:text>&#xA;</xsl:text>
    <xsl:if test="count(.|$path)=count($path)">
      <xsl:apply-templates select="category">
        <xsl:with-param
           name="indent"
           select="concat($indent,'&#xA0;&#xA0;&#xA0;')"/>
      </xsl:apply-templates>
    </xsl:if>
  </xsl:template>

</xsl:stylesheet>
