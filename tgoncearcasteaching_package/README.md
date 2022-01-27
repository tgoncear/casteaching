## Instal·lació

npm install tgoncearcasteaching

## Usage

import tgoncearcasteaching from 'tgoncearcasteaching'

// Obtenir llista de vídeos publicats
tgoncearcasteaching.videos()

// Obtenir vídeo per ID
tgoncearcasteaching.video.show(1)

// Crear video
tgoncearcasteaching.video.create({name: 'PHP 101', description: 'Bla bla bla',  url: 'https://youtube.com/...' })

// Update video
tgoncearcasteaching.video.update(1,{name: 'PHP 101', description: 'Bla bla bla',  url: 'https://youtube.com/...' })

// Destroy
tgoncearcasteaching.video.destroy(1)
