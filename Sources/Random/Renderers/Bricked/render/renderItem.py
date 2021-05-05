import bpy
bpy.ops.wm.open_mainfile(filepath="/var/render/avatar.blend")
gearpath = '/var/render/models/none.obj'
import_gear = bpy.ops.import_scene.obj(filepath=gearpath)
gear = bpy.context.selected_objects[0]
bpy.context.selected_objects[0].data.name = 'gear'
gearImg = bpy.data.images.load(filepath='/var/render/textures/none.png')
gearTex = bpy.data.textures.new('ColorTex', type = 'IMAGE')
gearTex.image = gearImg
gearMat = bpy.data.materials.new('MaterialName')
gearMat.diffuse_shader = 'LAMBERT'
gearSlot = gearMat.texture_slots.add()
gearSlot.texture = gearTex
gear.active_material = gearMat
gear2path = '/var/render/models/secondnone.obj'
import_gear2 = bpy.ops.import_scene.obj(filepath=gear2path)
gear2 = bpy.context.selected_objects[0]
bpy.context.selected_objects[0].data.name = 'gear2'
gear2Img = bpy.data.images.load(filepath='/var/render/textures/none.png')
gear2Tex = bpy.data.textures.new('ColorTex', type = 'IMAGE')
gear2Tex.image = gear2Img
gear2Mat = bpy.data.materials.new('MaterialName')
gear2Mat.diffuse_shader = 'LAMBERT'
gear2Slot = gear2Mat.texture_slots.add()
gear2Slot.texture = gear2Tex
gear2.active_material = gear2Mat
hatpath = '/var/render/models/none.obj'
import_hat = bpy.ops.import_scene.obj(filepath=hatpath)
hat = bpy.context.selected_objects[0]
bpy.context.selected_objects[0].data.name = 'hat'
hatImg = bpy.data.images.load(filepath='/var/render/textures/none.png')
hatTex = bpy.data.textures.new('ColorTex', type = 'IMAGE')
hatTex.image = hatImg
hatMat = bpy.data.materials.new('MaterialName')
hatMat.diffuse_shader = 'LAMBERT'
hatSlot = hatMat.texture_slots.add()
hatSlot.texture = hatTex
hat.active_material = hatMat
hat2path = '/var/render/models/none.obj'
import_hat2 = bpy.ops.import_scene.obj(filepath=hat2path)
hat2 = bpy.context.selected_objects[0]
bpy.context.selected_objects[0].data.name = 'hat2'
hat2Img = bpy.data.images.load(filepath='/var/render/textures/none.png')
hat2Tex = bpy.data.textures.new('ColorTex', type = 'IMAGE')
hat2Tex.image = hat2Img
hat2Mat = bpy.data.materials.new('MaterialName')
hat2Mat.diffuse_shader = 'LAMBERT'
hat2Slot = hat2Mat.texture_slots.add()
hat2Slot.texture = hat2Tex
hat2.active_material = hat2Mat
tshirtpath = '/var/render/models/none.obj'
import_tshirt = bpy.ops.import_scene.obj(filepath=tshirtpath)
tshirt = bpy.context.selected_objects[0]
bpy.context.selected_objects[0].data.name = 'tshirt'
tshirtImg = bpy.data.images.load(filepath='/var/render/textures/none.png')
tshirtTex = bpy.data.textures.new('ColorTex', type = 'IMAGE')
tshirtTex.image = tshirtImg
tshirtMat = bpy.data.materials.new('MaterialName')
tshirtMat.diffuse_shader = 'LAMBERT'
tshirtSlot = tshirtMat.texture_slots.add()
tshirtSlot.texture = tshirtTex
tshirt.active_material = tshirtMat
facepath = '/var/render/models/.obj'
import_face = bpy.ops.import_scene.obj(filepath=facepath)
face = bpy.context.selected_objects[0]
bpy.context.selected_objects[0].data.name = 'face'
faceImg = bpy.data.images.load(filepath='/var/render/textures/.png')
faceTex = bpy.data.textures.new('ColorTex', type = 'IMAGE')
faceTex.image = faceImg
faceMat = bpy.data.materials.new('MaterialName')
faceMat.diffuse_shader = 'LAMBERT'
faceSlot = faceMat.texture_slots.add()
faceSlot.texture = faceTex
face.active_material = faceMat
bpy.data.objects['Head'].select = True
bpy.data.objects['Head'].active_material.diffuse_color = (225/255,221/255,56/255)
bpy.data.objects['LeftArm'].select = True
bpy.data.objects['LeftArm'].active_material.diffuse_color = (225/255,221/255,56/255)
bpy.data.objects['RightArm'].select = True
bpy.data.objects['RightArm'].active_material.diffuse_color = (225/255,221/255,56/255)
bpy.data.objects['LeftLeg'].select = True
bpy.data.objects['LeftLeg'].active_material.diffuse_color = (135/255,155/255,58/255)
bpy.data.objects['RightLeg'].select = True
bpy.data.objects['RightLeg'].active_material.diffuse_color = (135/255,155/255,58/255)
bpy.data.objects['Torso'].select = True
bpy.data.objects['Torso'].active_material.diffuse_color = (16/255,113/255,184/255)

for ob in bpy.context.scene.objects:
	if ob.type == 'MESH':
		ob.select = True
		bpy.context.scene.objects.active = ob
	else:
		ob.select = False
bpy.ops.object.join()

bpy.ops.view3d.camera_to_view_selected()

origAlphaMode = bpy.data.scenes['Scene'].render.alpha_mode
bpy.data.scenes['Scene'].render.alpha_mode = 'TRANSPARENT'
bpy.data.scenes['Scene'].render.alpha_mode = origAlphaMode
bpy.data.scenes['Scene'].render.filepath = '/var/www/html/images/s.png'
bpy.ops.render.render( write_still=True )