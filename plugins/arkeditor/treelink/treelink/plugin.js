(function(){var n="treelink";CKEDITOR.plugins.add(n,{requires:"link",lang:"en,fi,de,fr,es,it",icons:"link",beforeInit:function(n){var t=CKEDITOR.document.getHead();t.append(CKEDITOR.document.createElement("link",{attributes:{type:"text/css",rel:"stylesheet",href:n.config.baseHref+"/media/editors/arkeditor/css/jtree.css"}}));t.append(CKEDITOR.document.createElement("script",{attributes:{type:"text/javascript",src:n.config.baseHref+"media/editors/arkeditor/js/jtree.js"}}))},init:function(){},afterInit:function(t){t.addCommand("link",new CKEDITOR.dialogCommand(n));CKEDITOR.dialog.add(n,this.path+"dialogs/"+n+".js");t.removeMenuItem&&t.removeMenuItem("link");t.addMenuItems&&t.addMenuItems({link:{label:t.lang.link.menu,command:"link",group:"link",order:1}});t.on("doubleclick",function(n){var i=CKEDITOR.plugins.link.getSelectedLink(t)||n.data.element;if(!i.isReadOnly())if(i.is("a")){if(i.getAttribute("name")||!i.getAttribute("href")&&i.getChildCount())i.getAttribute("name")&&(!i.getAttribute("href")||i.getChildCount())&&(n.data.dialog="anchor");else if(!/(?:[^\/])\/(([^\u0000-\u007F]|[\w-])+\.(?!(?:htm|php|asp|jsp|cfm|pl|cgi))\w+)$/.test(i.getAttribute("href")))return t.execCommand("link"),!1}else CKEDITOR.plugins.link.tryRestoreFakeAnchor(t,i)&&(n.data.dialog="anchor")},null,null,5)}});CKEDITOR.tools.extend(CKEDITOR.config,{treelinkShowAdvancedTab:!0,treelinkShowTargetTab:!0})})()