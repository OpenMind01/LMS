@extends('layouts.default')

@section('containerClasses', 'aside-in aside-right aside-bright')

@section('breadcrumbs-container')
@stop

@section('content')

    <button id="aside-toggle" class="btn btn-md btn-rounded btn-default"><i class="fa fa-caret-square-o-right"></i> <span>Hide Sidebar</span></button>
    <div id="page-title" style="padding-left: 0;">
        <h1 class="page-header text-overflow">Article Name</h1>
    </div>

    <section id="lesson-content">
        <!-- READ -->
        <div class="tab-base lesson-section lesson-visible" id="read-section">
            <div class="tab-content">
                <div class="panel-heading">

                    <h3 class="panel-title">Course Lesson Title</h3>
                </div>
                <hr>


                <div id="topic-" class="">
                    <div class="row mode-toggler mode-bottom">
                        <div class="col-sm-9">
                            <div id="lesson-body" class="panel-body body-editable" data-id="body">
                                <div id="preview-contents" style="padding-left: 35px; padding-right: 35px;">
						<div id="wmd-preview" class="preview-content"></div>
					<div id="wmd-preview-section-1" class="wmd-preview-section preview-content">

</div><div id="wmd-preview-section-2" class="wmd-preview-section preview-content">

<h1 id="welcome-to-Pi" style="margin-top: 0;">Welcome to Pi!</h1>

<p>Hey! I’m your first Markdown document in <strong>Pi</strong><a href="#fn:Pi" id="fnref:Pi" title="See footnote" class="footnote">1</a>. Don’t delete me, I’m very helpful! I can be recovered anyway in the <strong>Utils</strong> tab of the <i class="icon-cog"></i> <strong>Settings</strong> dialog.</p>

<hr>

</div><div id="wmd-preview-section-3" class="wmd-preview-section preview-content">

<h2 id="documents">Documents</h2>

<p>Pi stores your documents in your browser, which means all your documents are automatically saved locally and are accessible <strong>offline!</strong></p>

<blockquote>
  <p><strong>Note:</strong></p>
  
  <ul>
  <li>Pi is accessible offline after the application has been loaded for the first time.</li>
  <li>Your local documents are not shared between different browsers or computers.</li>
  <li>Clearing your browser’s data may <strong>delete all your local documents!</strong> Make sure your documents are synchronized with <strong>Google Drive</strong> or <strong>Dropbox</strong> (check out the <a href="#synchronization"><i class="icon-refresh"></i> Synchronization</a> section).</li>
  </ul>
</blockquote>

</div><div id="wmd-preview-section-4" class="wmd-preview-section preview-content">

<h4 id="create-a-document"><i class="icon-file"></i> Create a document</h4>

<p>The document panel is accessible using the <i class="icon-folder-open"></i> button in the navigation bar. You can create a new document by clicking <i class="icon-file"></i> <strong>New document</strong> in the document panel.</p>

</div><div id="wmd-preview-section-5" class="wmd-preview-section preview-content">

<h4 id="switch-to-another-document"><i class="icon-folder-open"></i> Switch to another document</h4>

<p>All your local documents are listed in the document panel. You can switch from one to another by clicking a document in the list or you can toggle documents using <kbd>Ctrl+[</kbd> and <kbd>Ctrl+]</kbd>.</p>

</div><div id="wmd-preview-section-6" class="wmd-preview-section preview-content">

<h4 id="rename-a-document"><i class="icon-pencil"></i> Rename a document</h4>

<p>You can rename the current document by clicking the document title in the navigation bar.</p>

</div><div id="wmd-preview-section-7" class="wmd-preview-section preview-content">

<h4 id="delete-a-document"><i class="icon-trash"></i> Delete a document</h4>

<p>You can delete the current document by clicking <i class="icon-trash"></i> <strong>Delete document</strong> in the document panel.</p>

</div><div id="wmd-preview-section-8" class="wmd-preview-section preview-content">

<h4 id="export-a-document"><i class="icon-hdd"></i> Export a document</h4>

<p>You can save the current document to a file by clicking <i class="icon-hdd"></i> <strong>Export to disk</strong> from the <i class="icon-provider-Pi"></i> menu panel.</p>

<blockquote>
  <p><strong>Tip:</strong> Check out the <a href="#publish-a-document"><i class="icon-upload"></i> Publish a document</a> section for a description of the different output formats.</p>
</blockquote>

<hr>

</div><div id="wmd-preview-section-9" class="wmd-preview-section preview-content">

<h2 id="synchronization">Synchronization</h2>

<p>Pi can be combined with <i class="icon-provider-gdrive"></i> <strong>Google Drive</strong> and <i class="icon-provider-dropbox"></i> <strong>Dropbox</strong> to have your documents saved in the <em>Cloud</em>. The synchronization mechanism takes care of uploading your modifications or downloading the latest version of your documents.</p>

<blockquote>
  <p><strong>Note:</strong></p>
  
  <ul>
  <li>Full access to <strong>Google Drive</strong> or <strong>Dropbox</strong> is required to be able to import any document in Pi. Permission restrictions can be configured in the settings.</li>
  <li>Imported documents are downloaded in your browser and are not transmitted to a server.</li>
  <li>If you experience problems saving your documents on Google Drive, check and optionally disable browser extensions, such as Disconnect.</li>
  </ul>
</blockquote>

</div><div id="wmd-preview-section-10" class="wmd-preview-section preview-content">

<h4 id="open-a-document"><i class="icon-refresh"></i> Open a document</h4>

<p>You can open a document from <i class="icon-provider-gdrive"></i> <strong>Google Drive</strong> or the <i class="icon-provider-dropbox"></i> <strong>Dropbox</strong> by opening the <i class="icon-refresh"></i> <strong>Synchronize</strong> sub-menu and by clicking <strong>Open from…</strong>. Once opened, any modification in your document will be automatically synchronized with the file in your <strong>Google Drive</strong> / <strong>Dropbox</strong> account.</p>

</div><div id="wmd-preview-section-11" class="wmd-preview-section preview-content">

<h4 id="save-a-document"><i class="icon-refresh"></i> Save a document</h4>

<p>You can save any document by opening the <i class="icon-refresh"></i> <strong>Synchronize</strong> sub-menu and by clicking <strong>Save on…</strong>. Even if your document is already synchronized with <strong>Google Drive</strong> or <strong>Dropbox</strong>, you can export it to a another location. Pi can synchronize one document with multiple locations and accounts.</p>

</div><div id="wmd-preview-section-12" class="wmd-preview-section preview-content">

<h4 id="synchronize-a-document"><i class="icon-refresh"></i> Synchronize a document</h4>

<p>Once your document is linked to a <i class="icon-provider-gdrive"></i> <strong>Google Drive</strong> or a <i class="icon-provider-dropbox"></i> <strong>Dropbox</strong> file, Pi will periodically (every 3 minutes) synchronize it by downloading/uploading any modification. A merge will be performed if necessary and conflicts will be detected.</p>

<p>If you just have modified your document and you want to force the synchronization, click the <i class="icon-refresh"></i> button in the navigation bar.</p>

<blockquote>
  <p><strong>Note:</strong> The <i class="icon-refresh"></i> button is disabled when you have no document to synchronize.</p>
</blockquote>

</div><div id="wmd-preview-section-13" class="wmd-preview-section preview-content">

<h4 id="manage-document-synchronization"><i class="icon-refresh"></i> Manage document synchronization</h4>

<p>Since one document can be synchronized with multiple locations, you can list and manage synchronized locations by clicking <i class="icon-refresh"></i> <strong>Manage synchronization</strong> in the <i class="icon-refresh"></i> <strong>Synchronize</strong> sub-menu. This will let you remove synchronization locations that are associated to your document.</p>

<blockquote>
  <p><strong>Note:</strong> If you delete the file from <strong>Google Drive</strong> or from <strong>Dropbox</strong>, the document will no longer be synchronized with that location.</p>
</blockquote>

<hr>

</div><div id="wmd-preview-section-14" class="wmd-preview-section preview-content">

<h2 id="publication">Publication</h2>

<p>Once you are happy with your document, you can publish it on different websites directly from Pi. As for now, Pi can publish on <strong>Blogger</strong>, <strong>Dropbox</strong>, <strong>Gist</strong>, <strong>GitHub</strong>, <strong>Google Drive</strong>, <strong>Tumblr</strong>, <strong>WordPress</strong> and on any SSH server.</p>

</div><div id="wmd-preview-section-15" class="wmd-preview-section preview-content">

<h4 id="publish-a-document"><i class="icon-upload"></i> Publish a document</h4>

<p>You can publish your document by opening the <i class="icon-upload"></i> <strong>Publish</strong> sub-menu and by choosing a website. In the dialog box, you can choose the publication format:</p>

<ul>
<li>Markdown, to publish the Markdown text on a website that can interpret it (<strong>GitHub</strong> for instance),</li>
<li>HTML, to publish the document converted into HTML (on a blog for example),</li>
<li>Template, to have a full control of the output.</li>
</ul>

<blockquote>
  <p><strong>Note:</strong> The default template is a simple webpage wrapping your document in HTML format. You can customize it in the <strong>Advanced</strong> tab of the <i class="icon-cog"></i> <strong>Settings</strong> dialog.</p>
</blockquote>

</div><div id="wmd-preview-section-16" class="wmd-preview-section preview-content">

<h4 id="update-a-publication"><i class="icon-upload"></i> Update a publication</h4>

<p>After publishing, Pi will keep your document linked to that publication which makes it easy for you to update it. Once you have modified your document and you want to update your publication, click on the <i class="icon-upload"></i> button in the navigation bar.</p>

<blockquote>
  <p><strong>Note:</strong> The <i class="icon-upload"></i> button is disabled when your document has not been published yet.</p>
</blockquote>

</div><div id="wmd-preview-section-17" class="wmd-preview-section preview-content">

<h4 id="manage-document-publication"><i class="icon-upload"></i> Manage document publication</h4>

<p>Since one document can be published on multiple locations, you can list and manage publish locations by clicking <i class="icon-upload"></i> <strong>Manage publication</strong> in the <i class="icon-provider-Pi"></i> menu panel. This will let you remove publication locations that are associated to your document.</p>

<blockquote>
  <p><strong>Note:</strong> If the file has been removed from the website or the blog, the document will no longer be published on that location.</p>
</blockquote>

<hr>

</div><div id="wmd-preview-section-18" class="wmd-preview-section preview-content">

<h2 id="markdown-extra">Markdown Extra</h2>

<p>Pi supports <strong>Markdown Extra</strong>, which extends <strong>Markdown</strong> syntax with some nice features.</p>

<blockquote>
  <p><strong>Tip:</strong> You can disable any <strong>Markdown Extra</strong> feature in the <strong>Extensions</strong> tab of the <i class="icon-cog"></i> <strong>Settings</strong> dialog.</p>
  
  <p><strong>Note:</strong> You can find more information about <strong>Markdown</strong> syntax <a href="http://daringfireball.net/projects/markdown/syntax" title="Markdown">here</a> and <strong>Markdown Extra</strong> extension <a href="https://github.com/jmcmanus/pagedown-extra" title="Pagedown Extra">here</a>.</p>
</blockquote>

</div><div id="wmd-preview-section-19" class="wmd-preview-section preview-content">

<h3 id="tables">Tables</h3>

<p><strong>Markdown Extra</strong> has a special syntax for tables:</p>

<table>
<thead>
<tr>
  <th>Item</th>
  <th>Value</th>
</tr>
</thead>
<tbody><tr>
  <td>Computer</td>
  <td>$1600</td>
</tr>
<tr>
  <td>Phone</td>
  <td>$12</td>
</tr>
<tr>
  <td>Pipe</td>
  <td>$1</td>
</tr>
</tbody></table>


<p>You can specify column alignment with one or two colons:</p>

<table>
<thead>
<tr>
  <th align="left">Item</th>
  <th align="right">Value</th>
  <th align="center">Qty</th>
</tr>
</thead>
<tbody><tr>
  <td align="left">Computer</td>
  <td align="right">$1600</td>
  <td align="center">5</td>
</tr>
<tr>
  <td align="left">Phone</td>
  <td align="right">$12</td>
  <td align="center">12</td>
</tr>
<tr>
  <td align="left">Pipe</td>
  <td align="right">$1</td>
  <td align="center">234</td>
</tr>
</tbody></table>


</div><div id="wmd-preview-section-20" class="wmd-preview-section preview-content">

<h3 id="definition-lists">Definition Lists</h3>

<p><strong>Markdown Extra</strong> has a special syntax for definition lists too:</p>

<dl>
<dt>Term 1</dt>
<dt>Term 2</dt>
<dd>Definition A</dd>

<dd>Definition B</dd>

<dt>Term 3</dt>
<dd>
<p>Definition C</p>
</dd>

<dd>
<p>Definition D</p>

<blockquote>
  <p>part of definition D</p>
</blockquote>
</dd>
</dl>

</div><div id="wmd-preview-section-21" class="wmd-preview-section preview-content">

<h3 id="fenced-code-blocks">Fenced code blocks</h3>

<p>GitHub’s fenced code blocks are also supported with <strong>Highlight.js</strong> syntax highlighting:</p>

</div><div id="wmd-preview-section-22" class="wmd-preview-section preview-content">

<pre class="prettyprint"><code class=" hljs cs"><span class="hljs-comment">// Foo</span>
<span class="hljs-keyword">var</span> bar = <span class="hljs-number">0</span>;</code></pre>

<blockquote>
  <p><strong>Tip:</strong> To use <strong>Prettify</strong> instead of <strong>Highlight.js</strong>, just configure the <strong>Markdown Extra</strong> extension in the <i class="icon-cog"></i> <strong>Settings</strong> dialog.</p>
  
  <p><strong>Note:</strong> You can find more information:</p>
  
  <ul>
  <li>about <strong>Prettify</strong> syntax highlighting <a href="https://code.google.com/p/google-code-prettify/">here</a>,</li>
  <li>about <strong>Highlight.js</strong> syntax highlighting <a href="http://highlightjs.org/">here</a>.</li>
  </ul>
</blockquote>

</div><div id="wmd-preview-section-23" class="wmd-preview-section preview-content">

<h3 id="footnotes">Footnotes</h3>

<p>You can create footnotes like this<a href="#fn:footnote" id="fnref:footnote" title="See footnote" class="footnote">2</a>.</p>

</div><div id="wmd-preview-section-24" class="wmd-preview-section preview-content">

<h3 id="smartypants">SmartyPants</h3>

<p>SmartyPants converts ASCII punctuation characters into “smart” typographic punctuation HTML entities. For example:</p>

<table>
<thead>
<tr>
  <th></th>
  <th>ASCII</th>
  <th>HTML</th>
</tr>
</thead>
<tbody><tr>
  <td>Single backticks</td>
  <td><code>'Isn't this fun?'</code></td>
  <td>‘Isn’t this fun?’</td>
</tr>
<tr>
  <td>Quotes</td>
  <td><code>"Isn't this fun?"</code></td>
  <td>“Isn’t this fun?”</td>
</tr>
<tr>
  <td>Dashes</td>
  <td><code>-- is en-dash, --- is em-dash</code></td>
  <td>– is en-dash, — is em-dash</td>
</tr>
</tbody></table>


</div><div id="wmd-preview-section-25" class="wmd-preview-section preview-content">

<h3 id="table-of-contents">Table of contents</h3>

<p>You can insert a table of contents using the marker <code>[TOC]</code>:</p>

<p><div class="toc">
<ul>
<li><a href="#welcome-to-Pi">Welcome to Pi!</a><ul>
<li><a href="#documents">Documents</a><ul>
<li><ul>
<li><a href="#create-a-document"> Create a document</a></li>
<li><a href="#switch-to-another-document"> Switch to another document</a></li>
<li><a href="#rename-a-document"> Rename a document</a></li>
<li><a href="#delete-a-document"> Delete a document</a></li>
<li><a href="#export-a-document"> Export a document</a></li>
</ul>
</li>
</ul>
</li>
<li><a href="#synchronization">Synchronization</a><ul>
<li><ul>
<li><a href="#open-a-document"> Open a document</a></li>
<li><a href="#save-a-document"> Save a document</a></li>
<li><a href="#synchronize-a-document"> Synchronize a document</a></li>
<li><a href="#manage-document-synchronization"> Manage document synchronization</a></li>
</ul>
</li>
</ul>
</li>
<li><a href="#publication">Publication</a><ul>
<li><ul>
<li><a href="#publish-a-document"> Publish a document</a></li>
<li><a href="#update-a-publication"> Update a publication</a></li>
<li><a href="#manage-document-publication"> Manage document publication</a></li>
</ul>
</li>
</ul>
</li>
<li><a href="#markdown-extra">Markdown Extra</a><ul>
<li><a href="#tables">Tables</a></li>
<li><a href="#definition-lists">Definition Lists</a></li>
<li><a href="#fenced-code-blocks">Fenced code blocks</a></li>
<li><a href="#footnotes">Footnotes</a></li>
<li><a href="#smartypants">SmartyPants</a></li>
<li><a href="#table-of-contents">Table of contents</a></li>
<li><a href="#mathjax">MathJax</a></li>
<li><a href="#uml-diagrams">UML diagrams</a></li>
<li><a href="#support-Pi">Support Pi</a></li>
</ul>
</li>
</ul>
</li>
</ul>
</div>
</p>

</div><div id="wmd-preview-section-26" class="wmd-preview-section preview-content">

<h3 id="mathjax">MathJax</h3>

<p>You can render <em>LaTeX</em> mathematical expressions using <strong>MathJax</strong>, as on <a href="http://math.stackexchange.com/">math.stackexchange.com</a>:</p>

<p>The <em>Gamma function</em> satisfying <span class="MathJax_Preview" style="color: inherit;"></span><span class="MathJax" id="MathJax-Element-1-Frame" style=""><nobr><span class="math" id="MathJax-Span-1" role="math" style="width: 12.106em; display: inline-block;"><span style="display: inline-block; position: relative; width: 10.816em; height: 0px; font-size: 112%;"><span style="position: absolute; clip: rect(2.086em, 1000.002em, 3.375em, -999.998em); top: -2.974em; left: 0.002em;"><span class="mrow" id="MathJax-Span-2"><span class="mi" id="MathJax-Span-3" style="font-family: MathJax_Main;">Γ</span><span class="mo" id="MathJax-Span-4" style="font-family: MathJax_Main;">(</span><span class="mi" id="MathJax-Span-5" style="font-family: MathJax_Math-italic;">n</span><span class="mo" id="MathJax-Span-6" style="font-family: MathJax_Main;">)</span><span class="mo" id="MathJax-Span-7" style="font-family: MathJax_Main; padding-left: 0.3em;">=</span><span class="mo" id="MathJax-Span-8" style="font-family: MathJax_Main; padding-left: 0.3em;">(</span><span class="mi" id="MathJax-Span-9" style="font-family: MathJax_Math-italic;">n</span><span class="mo" id="MathJax-Span-10" style="font-family: MathJax_Main; padding-left: 0.201em;">−</span><span class="mn" id="MathJax-Span-11" style="font-family: MathJax_Main; padding-left: 0.201em;">1</span><span class="mo" id="MathJax-Span-12" style="font-family: MathJax_Main;">)</span><span class="mo" id="MathJax-Span-13" style="font-family: MathJax_Main;">!</span><span class="mspace" id="MathJax-Span-14" style="height: 0.002em; vertical-align: 0.002em; width: 0.995em; display: inline-block; overflow: hidden;"></span><span class="mi" id="MathJax-Span-15" style="font-family: MathJax_Main;">∀</span><span class="mi" id="MathJax-Span-16" style="font-family: MathJax_Math-italic;">n</span><span class="mo" id="MathJax-Span-17" style="font-family: MathJax_Main; padding-left: 0.3em;">∈</span><span class="texatom" id="MathJax-Span-18" style="padding-left: 0.3em;"><span class="mrow" id="MathJax-Span-19"><span class="mi" id="MathJax-Span-20" style="font-family: MathJax_AMS;">N</span></span></span></span><span style="display: inline-block; width: 0px; height: 2.979em;"></span></span></span><span style="border-left-width: 0.003em; border-left-style: solid; display: inline-block; overflow: hidden; width: 0px; height: 1.225em; vertical-align: -0.331em;"></span></span></nobr></span><script type="math/tex" id="MathJax-Element-1">\Gamma(n) = (n-1)!\quad\forall n\in\mathbb N</script> is via the Euler integral</p>

</div><div id="wmd-preview-section-27" class="wmd-preview-section preview-content">

<p><span class="MathJax_Preview" style="color: inherit;"></span><div class="MathJax_Display" style="text-align: center;"><span class="MathJax" id="MathJax-Element-2-Frame" style=""><nobr><span class="math" id="MathJax-Span-21" role="math" style="width: 10.816em; display: inline-block;"><span style="display: inline-block; position: relative; width: 9.625em; height: 0px; font-size: 112%;"><span style="position: absolute; clip: rect(1.143em, 1000.002em, 3.723em, -999.998em); top: -2.676em; left: 0.002em;"><span class="mrow" id="MathJax-Span-22"><span class="mi" id="MathJax-Span-23" style="font-family: MathJax_Main;">Γ</span><span class="mo" id="MathJax-Span-24" style="font-family: MathJax_Main;">(</span><span class="mi" id="MathJax-Span-25" style="font-family: MathJax_Math-italic;">z<span style="display: inline-block; overflow: hidden; height: 1px; width: 0.002em;"></span></span><span class="mo" id="MathJax-Span-26" style="font-family: MathJax_Main;">)</span><span class="mo" id="MathJax-Span-27" style="font-family: MathJax_Main; padding-left: 0.3em;">=</span><span class="msubsup" id="MathJax-Span-28" style="padding-left: 0.3em;"><span style="display: inline-block; position: relative; width: 1.887em; height: 0px;"><span style="position: absolute; clip: rect(2.532em, 1000.002em, 5.012em, -999.998em); top: -4.015em; left: 0.002em;"><span class="mo" id="MathJax-Span-29" style="font-family: MathJax_Size2; vertical-align: 0.002em;">∫<span style="display: inline-block; overflow: hidden; height: 1px; width: 0.399em;"></span></span><span style="display: inline-block; width: 0px; height: 4.02em;"></span></span><span style="position: absolute; clip: rect(3.574em, 1000.002em, 4.169em, -999.998em); top: -5.107em; left: 1.094em;"><span class="mi" id="MathJax-Span-30" style="font-size: 70.7%; font-family: MathJax_Main;">∞</span><span style="display: inline-block; width: 0px; height: 4.02em;"></span></span><span style="position: absolute; clip: rect(3.425em, 1000.002em, 4.169em, -999.998em); top: -3.123em; left: 0.548em;"><span class="mn" id="MathJax-Span-31" style="font-size: 70.7%; font-family: MathJax_Main;">0</span><span style="display: inline-block; width: 0px; height: 4.02em;"></span></span></span></span><span class="msubsup" id="MathJax-Span-32" style="padding-left: 0.151em;"><span style="display: inline-block; position: relative; width: 1.689em; height: 0px;"><span style="position: absolute; clip: rect(3.227em, 1000.002em, 4.169em, -999.998em); top: -4.015em; left: 0.002em;"><span class="mi" id="MathJax-Span-33" style="font-family: MathJax_Math-italic;">t</span><span style="display: inline-block; width: 0px; height: 4.02em;"></span></span><span style="position: absolute; top: -4.412em; left: 0.35em;"><span class="texatom" id="MathJax-Span-34"><span class="mrow" id="MathJax-Span-35"><span class="mi" id="MathJax-Span-36" style="font-size: 70.7%; font-family: MathJax_Math-italic;">z<span style="display: inline-block; overflow: hidden; height: 1px; width: 0.002em;"></span></span><span class="mo" id="MathJax-Span-37" style="font-size: 70.7%; font-family: MathJax_Main;">−</span><span class="mn" id="MathJax-Span-38" style="font-size: 70.7%; font-family: MathJax_Main;">1</span></span></span><span style="display: inline-block; width: 0px; height: 4.02em;"></span></span></span></span><span class="msubsup" id="MathJax-Span-39"><span style="display: inline-block; position: relative; width: 1.342em; height: 0px;"><span style="position: absolute; clip: rect(3.425em, 1000.002em, 4.169em, -999.998em); top: -4.015em; left: 0.002em;"><span class="mi" id="MathJax-Span-40" style="font-family: MathJax_Math-italic;">e</span><span style="display: inline-block; width: 0px; height: 4.02em;"></span></span><span style="position: absolute; top: -4.412em; left: 0.449em;"><span class="texatom" id="MathJax-Span-41"><span class="mrow" id="MathJax-Span-42"><span class="mo" id="MathJax-Span-43" style="font-size: 70.7%; font-family: MathJax_Main;">−</span><span class="mi" id="MathJax-Span-44" style="font-size: 70.7%; font-family: MathJax_Math-italic;">t</span></span></span><span style="display: inline-block; width: 0px; height: 4.02em;"></span></span></span></span><span class="mi" id="MathJax-Span-45" style="font-family: MathJax_Math-italic;">d<span style="display: inline-block; overflow: hidden; height: 1px; width: 0.002em;"></span></span><span class="mi" id="MathJax-Span-46" style="font-family: MathJax_Math-italic;">t</span><span class="mspace" id="MathJax-Span-47" style="height: 0.002em; vertical-align: 0.002em; width: 0.151em; display: inline-block; overflow: hidden;"></span><span class="mo" id="MathJax-Span-48" style="font-family: MathJax_Main;">.</span></span><span style="display: inline-block; width: 0px; height: 2.681em;"></span></span></span><span style="border-left-width: 0.003em; border-left-style: solid; display: inline-block; overflow: hidden; width: 0px; height: 2.725em; vertical-align: -1.053em;"></span></span></nobr></span></div><script type="math/tex; mode=display" id="MathJax-Element-2">
\Gamma(z) = \int_0^\infty t^{z-1}e^{-t}dt\,.
</script></p>

<blockquote>
  <p><strong>Tip:</strong> To make sure mathematical expressions are rendered properly on your website, include <strong>MathJax</strong> into your template:</p>
</blockquote>

</div><div id="wmd-preview-section-28" class="wmd-preview-section preview-content">

<pre class="prettyprint"><code class=" hljs xml"><span class="hljs-tag">&lt;<span class="hljs-title">script</span> <span class="hljs-attribute">type</span>=<span class="hljs-value">"text/javascript"</span> <span class="hljs-attribute">src</span>=<span class="hljs-value">"https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS_HTML"</span>&gt;</span><span class="javascript"></span><span class="hljs-tag">&lt;/<span class="hljs-title">script</span>&gt;</span></code></pre>

<blockquote>
  <p><strong>Note:</strong> You can find more information about <strong>LaTeX</strong> mathematical expressions <a href="http://meta.math.stackexchange.com/questions/5020/mathjax-basic-tutorial-and-quick-reference">here</a>.</p>
</blockquote>

</div><div id="wmd-preview-section-29" class="wmd-preview-section preview-content">

<h3 id="uml-diagrams">UML diagrams</h3>

<p>You can also render sequence diagrams like this:</p>

</div><div id="wmd-preview-section-30" class="wmd-preview-section preview-content">

<div class="sequence-diagram"><svg height="264.375" version="1.1" width="375.703125" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative; top: -0.734375px;"><desc>Created with Raphaël 2.1.2</desc><defs><path stroke-linecap="round" d="M5,0 0,2.5 5,5z" id="raphael-marker-block"></path><marker id="raphael-marker-endblock55-obj21" markerHeight="5" markerWidth="5" orient="auto" refX="2.5" refY="2.5"><use NS1:href="#raphael-marker-block" transform="rotate(180 2.5 2.5) scale(1,1)" stroke-width="1.0000" fill="#000" stroke="none"></use></marker><marker id="raphael-marker-endblock55-obj27" markerHeight="5" markerWidth="5" orient="auto" refX="2.5" refY="2.5"><use NS2:href="#raphael-marker-block" transform="rotate(180 2.5 2.5) scale(1,1)" stroke-width="1.0000" fill="#000" stroke="none"></use></marker></defs><rect x="10" y="20" width="49.875" height="38.875" rx="0" ry="0" fill="none" stroke="#000000" stroke-width="2" style=""></rect><rect x="20" y="30" width="29.875" height="18.875" rx="0" ry="0" fill="#ffffff" stroke="none" style=""></rect><text x="34.9375" y="39.4375" text-anchor="middle" font-family="Andale Mono, monospace" font-size="16px" stroke="none" fill="#000000" style="text-anchor: middle; font-family: 'Andale Mono', monospace; font-size: 16px;"><tspan dy="5.328125">Alice</tspan></text><rect x="10" y="205.5" width="49.875" height="38.875" rx="0" ry="0" fill="none" stroke="#000000" stroke-width="2" style=""></rect><rect x="20" y="215.5" width="29.875" height="18.875" rx="0" ry="0" fill="#ffffff" stroke="none" style=""></rect><text x="34.9375" y="224.9375" text-anchor="middle" font-family="Andale Mono, monospace" font-size="16px" stroke="none" fill="#000000" style="text-anchor: middle; font-family: 'Andale Mono', monospace; font-size: 16px;"><tspan dy="5.328125">Alice</tspan></text><path fill="none" stroke="#000000" d="M34.9375,58.875L34.9375,205.5" stroke-width="2" style=""></path><rect x="183.390625" y="20" width="45.21875" height="38.875" rx="0" ry="0" fill="none" stroke="#000000" stroke-width="2" style=""></rect><rect x="193.390625" y="30" width="25.21875" height="18.875" rx="0" ry="0" fill="#ffffff" stroke="none" style=""></rect><text x="206" y="39.4375" text-anchor="middle" font-family="Andale Mono, monospace" font-size="16px" stroke="none" fill="#000000" style="text-anchor: middle; font-family: 'Andale Mono', monospace; font-size: 16px;"><tspan dy="5.328125">Bob</tspan></text><rect x="183.390625" y="205.5" width="45.21875" height="38.875" rx="0" ry="0" fill="none" stroke="#000000" stroke-width="2" style=""></rect><rect x="193.390625" y="215.5" width="25.21875" height="18.875" rx="0" ry="0" fill="#ffffff" stroke="none" style=""></rect><text x="206" y="224.9375" text-anchor="middle" font-family="Andale Mono, monospace" font-size="16px" stroke="none" fill="#000000" style="text-anchor: middle; font-family: 'Andale Mono', monospace; font-size: 16px;"><tspan dy="5.328125">Bob</tspan></text><path fill="none" stroke="#000000" d="M206,58.875L206,205.5" stroke-width="2" style=""></path><rect x="44.9375" y="74.4375" width="151.0625" height="18.875" rx="0" ry="0" fill="#ffffff" stroke="none" style=""></rect><text x="120.46875" y="83.875" text-anchor="middle" font-family="Andale Mono, monospace" font-size="16px" stroke="none" fill="#000000" style="text-anchor: middle; font-family: 'Andale Mono', monospace; font-size: 16px;"><tspan dy="5.328125">Hello Bob, how are you?</tspan></text><path fill="none" stroke="#000000" d="M34.9375,97.75C34.9375,97.75,172.79239079728723,97.75,200.99610136567753,97.75" stroke-width="2" marker-end="url(#raphael-marker-endblock55-obj21)" stroke-dasharray="0" style=""></path><rect x="226" y="117.75" width="77.09375" height="28.875" rx="0" ry="0" fill="none" stroke="#000000" stroke-width="2" style=""></rect><rect x="231" y="122.75" width="67.09375" height="18.875" rx="0" ry="0" fill="#ffffff" stroke="none" style=""></rect><text x="264.546875" y="132.1875" text-anchor="middle" font-family="Andale Mono, monospace" font-size="16px" stroke="none" fill="#000000" style="text-anchor: middle; font-family: 'Andale Mono', monospace; font-size: 16px;"><tspan dy="5.328125">Bob thinks</tspan></text><rect x="64.265625" y="162.1875" width="112.40625" height="18.875" rx="0" ry="0" fill="#ffffff" stroke="none" style=""></rect><text x="120.46875" y="171.625" text-anchor="middle" font-family="Andale Mono, monospace" font-size="16px" stroke="none" fill="#000000" style="text-anchor: middle; font-family: 'Andale Mono', monospace; font-size: 16px;"><tspan dy="5.328125">I am good thanks!</tspan></text><path fill="none" stroke="#000000" d="M206,185.5C206,185.5,68.14510920271277,185.5,39.94139863432247,185.5" stroke-width="2" marker-end="url(#raphael-marker-endblock55-obj27)" stroke-dasharray="6,2" style=""></path></svg></div>

<p>And flow charts like this:</p>

</div><div id="wmd-preview-section-31" class="wmd-preview-section preview-content">

<div class="flow-chart"><svg height="403.177734375" version="1.1" width="172.4921875" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative; top: -0.328125px;"><desc>Created with Raphaël 2.1.2</desc><defs><marker id="raphael-marker-endblock33-obj36" markerHeight="3" markerWidth="3" orient="auto" refX="1.5" refY="1.5"><use NS3:href="#raphael-marker-block" transform="rotate(180 1.5 1.5) scale(0.6,0.6)" stroke-width="1.6667" fill="black" stroke="none"></use></marker><marker id="raphael-marker-endblock33-obj37" markerHeight="3" markerWidth="3" orient="auto" refX="1.5" refY="1.5"><use NS4:href="#raphael-marker-block" transform="rotate(180 1.5 1.5) scale(0.6,0.6)" stroke-width="1.6667" fill="black" stroke="none"></use></marker><marker id="raphael-marker-endblock33-obj38" markerHeight="3" markerWidth="3" orient="auto" refX="1.5" refY="1.5"><use NS5:href="#raphael-marker-block" transform="rotate(180 1.5 1.5) scale(0.6,0.6)" stroke-width="1.6667" fill="black" stroke="none"></use></marker><marker id="raphael-marker-endblock33-obj40" markerHeight="3" markerWidth="3" orient="auto" refX="1.5" refY="1.5"><use NS6:href="#raphael-marker-block" transform="rotate(180 1.5 1.5) scale(0.6,0.6)" stroke-width="1.6667" fill="black" stroke="none"></use></marker></defs><rect x="0" y="0" width="50.96875" height="38.875" rx="20" ry="20" fill="#ffffff" stroke="#000000" stroke-width="2" class="flowchart" id="st" transform="matrix(1,0,0,1,49.2617,19.9355)" style=""></rect><text x="10" y="19.4375" text-anchor="start" font-family="sans-serif" font-size="14px" stroke="none" fill="#000000" id="stt" class="flowchartt" font-weight="normal" transform="matrix(1,0,0,1,49.2617,19.9355)" style="text-anchor: start; font-family: sans-serif; font-size: 14px; font-weight: normal;"><tspan dy="5.328125">Start</tspan></text><rect x="0" y="0" width="104.5" height="38.875" rx="0" ry="0" fill="#ffffff" stroke="#000000" stroke-width="2" class="flowchart" id="op" transform="matrix(1,0,0,1,22.4961,128.7461)" style=""></rect><text x="10" y="19.4375" text-anchor="start" font-family="sans-serif" font-size="14px" stroke="none" fill="#000000" id="opt" class="flowchartt" font-weight="normal" transform="matrix(1,0,0,1,22.4961,128.7461)" style="text-anchor: start; font-family: sans-serif; font-size: 14px; font-weight: normal;"><tspan dy="5.328125">My Operation</tspan></text><path fill="#ffffff" stroke="#000000" d="M35.373046875,17.6865234375L0,35.373046875L70.74609375,70.74609375L141.4921875,35.373046875L70.74609375,0L0,35.373046875" stroke-width="2" font-family="sans-serif" font-weight="normal" id="cond" class="flowchart" transform="matrix(1,0,0,1,4,221.6211)" style="font-family: sans-serif; font-weight: normal;"></path><text x="40.373046875" y="35.373046875" text-anchor="start" font-family="sans-serif" font-size="14px" stroke="none" fill="#000000" id="condt" class="flowchartt" font-weight="normal" transform="matrix(1,0,0,1,4,221.6211)" style="text-anchor: start; font-family: sans-serif; font-size: 14px; font-weight: normal;"><tspan dy="5.333984375">Yes or No?</tspan><tspan dy="18" x="40.373046875"></tspan></text><rect x="0" y="0" width="44.375" height="38.875" rx="20" ry="20" fill="#ffffff" stroke="#000000" stroke-width="2" class="flowchart" id="e" transform="matrix(1,0,0,1,52.5586,362.3027)" style=""></rect><text x="10" y="19.4375" text-anchor="start" font-family="sans-serif" font-size="14px" stroke="none" fill="#000000" id="et" class="flowchartt" font-weight="normal" transform="matrix(1,0,0,1,52.5586,362.3027)" style="text-anchor: start; font-family: sans-serif; font-size: 14px; font-weight: normal;"><tspan dy="5.328125">End</tspan></text><path fill="none" stroke="#000000" d="M74.74609375,58.810546875C74.74609375,58.810546875,74.74609375,112.35494995117188,74.74609375,125.74105072021484" stroke-width="2" marker-end="url(#raphael-marker-endblock33-obj36)" font-family="sans-serif" font-weight="normal" style="font-family: sans-serif; font-weight: normal;"></path><path fill="none" stroke="#000000" d="M74.74609375,167.62109375C74.74609375,167.62109375,74.74609375,207.27519369125366,74.74609375,218.62153283460066" stroke-width="2" marker-end="url(#raphael-marker-endblock33-obj37)" font-family="sans-serif" font-weight="normal" style="font-family: sans-serif; font-weight: normal;"></path><path fill="none" stroke="#000000" d="M74.74609375,292.3671875C74.74609375,292.3671875,74.74609375,345.9115905761719,74.74609375,359.29769134521484" stroke-width="2" marker-end="url(#raphael-marker-endblock33-obj38)" font-family="sans-serif" font-weight="normal" style="font-family: sans-serif; font-weight: normal;"></path><text x="79.74609375" y="302.3671875" text-anchor="start" font-family="sans-serif" font-size="14px" stroke="none" fill="#000000" font-weight="normal" style="text-anchor: start; font-family: sans-serif; font-size: 14px; font-weight: normal;"><tspan dy="5.3359375">yes</tspan></text><path fill="none" stroke="#000000" d="M145.4921875,256.994140625C145.4921875,256.994140625,170.4921875,256.994140625,170.4921875,256.994140625C170.4921875,256.994140625,170.4921875,103.74609375,170.4921875,103.74609375C170.4921875,103.74609375,74.74609375,103.74609375,74.74609375,103.74609375C74.74609375,103.74609375,74.74609375,119.11953830718994,74.74609375,125.75534152425826" stroke-width="2" marker-end="url(#raphael-marker-endblock33-obj40)" font-family="sans-serif" font-weight="normal" style="font-family: sans-serif; font-weight: normal;"></path><text x="150.4921875" y="246.994140625" text-anchor="start" font-family="sans-serif" font-size="14px" stroke="none" fill="#000000" font-weight="normal" style="text-anchor: start; font-family: sans-serif; font-size: 14px; font-weight: normal;"><tspan dy="5.337890625">no</tspan></text></svg></div>

<blockquote>
  <p><strong>Note:</strong> You can find more information:</p>
  
  <ul>
  <li>about <strong>Sequence diagrams</strong> syntax <a href="http://bramp.github.io/js-sequence-diagrams/">here</a>,</li>
  <li>about <strong>Flow charts</strong> syntax <a href="http://adrai.github.io/flowchart.js/">here</a>.</li>
  </ul>
</blockquote>

</div><div id="wmd-preview-section-32" class="wmd-preview-section preview-content">

<h3 id="support-Pi">Support Pi</h3>

</div><div id="wmd-preview-section-footnotes" class="preview-content"><div class="footnotes"><hr><ol><li id="fn:Pi"><a href="https://Pi.io/">Pi</a> is a full-featured, open-source Markdown editor based on PageDown, the Markdown library used by Stack Overflow and the other Stack Exchange sites. <a href="#fnref:Pi" title="Return to article" class="reversefootnote">↩</a></li><li id="fn:footnote">Here is the <em>text</em> of the <strong>footnote</strong>. <a href="#fnref:footnote" title="Return to article" class="reversefootnote">↩</a></li></ol></div></div></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>

    <div class="row">
        <div class="col-sm-3">
            <a class="btn btn-success complete" href="#"></a>
        </div>
        <div class="col-sm-9">
            <div id="pi">
            </div>
        </div>
    </div>
@stop

@section('aside')
    @include('pages.clients.courses.modules.articles.partials.aside');
@stop

@section('inline-scripts')
    <script src="/assets/plugins/dropzone/dist/dropzone.js"></script>
    <link rel="stylesheet" href="/assets/plugins/dropzone/dist/dropzone.css">
    <script>

    </script>
    <script type="text/javascript" src="/assets/js/p4.js"></script>
@stop