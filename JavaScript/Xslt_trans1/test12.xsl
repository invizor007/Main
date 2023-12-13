<?xml version="1.0" encoding="windows-1251" ?>
<xsl:transform xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="div" encoding="windows-1251" indent="yes" />

	<xsl:template match="/">
		<h1>New Version!</h1>
		<xsl:apply-templates/>
	</xsl:template>

	<xsl:template match="@*|node()">
		<xsl:copy>
			<xsl:apply-templates select="@*|node()"/>
		</xsl:copy>
	</xsl:template>
</xsl:transform>
